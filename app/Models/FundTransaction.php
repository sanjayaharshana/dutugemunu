<?php

namespace App\Models;

use App\Support\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * A single addition (money in) or deduction (money out) on the association's
 * funds. The total balance and the per-fund breakdown shown to members and
 * admins are always computed from this table — there is no separate
 * "total" figure stored anywhere.
 */
class FundTransaction extends Model
{
    protected $fillable = ['type', 'category', 'title', 'amount', 'notes', 'date', 'created_by'];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    /** Suggested fund names offered in the admin form; admins can also type a new one. */
    const CATEGORIES = [
        'General Fund',
        'Scholarship Fund',
        'Building & Development Fund',
        'Welfare Fund',
    ];

    public function scopeAdditions(Builder $query): Builder
    {
        return $query->where('type', 'addition');
    }

    public function scopeDeductions(Builder $query): Builder
    {
        return $query->where('type', 'deduction');
    }

    public function amountFormatted(): string
    {
        return Money::format($this->amount);
    }

    public function isAddition(): bool
    {
        return $this->type === 'addition';
    }

    /** Current balance across every fund: total additions minus total deductions. */
    public static function totalBalance(): float
    {
        return (float) static::additions()->sum('amount') - (float) static::deductions()->sum('amount');
    }

    /** Net balance per fund/category, highest first. */
    public static function breakdownByCategory(): Collection
    {
        return static::query()
            ->selectRaw("category, SUM(CASE WHEN type = 'addition' THEN amount ELSE -amount END) as net")
            ->groupBy('category')
            ->orderByDesc('net')
            ->get();
    }

    public static function latestDate(): ?string
    {
        return static::max('date');
    }

    /**
     * Cumulative fund balance, one point per month, for the "Funds Growth" line
     * chart. Starts one month before the first-ever transaction (anchored at 0)
     * so even a single month of history plots a real line.
     * Returns ['labels' => [...], 'values' => [...]], both empty if there are no transactions yet.
     */
    public static function growthSeries(): array
    {
        $first = static::query()->min('date');

        if (! $first) {
            return ['labels' => [], 'values' => []];
        }

        $byMonth = static::query()->get(['date', 'type', 'amount'])
            ->groupBy(fn (self $t) => Carbon::parse($t->date)->format('Y-m'))
            ->map(fn (Collection $rows) => $rows->sum(fn (self $t) => $t->isAddition() ? (float) $t->amount : -(float) $t->amount));

        $cursor = Carbon::parse($first)->startOfMonth()->subMonth();
        $end = Carbon::now()->startOfMonth();

        $labels = [];
        $values = [];
        $cumulative = 0.0;

        while ($cursor->lte($end)) {
            $cumulative += $byMonth->get($cursor->format('Y-m'), 0);
            $labels[] = $cursor->format('M Y');
            $values[] = round($cumulative);
            $cursor->addMonth();
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
