<?php

/*
|--------------------------------------------------------------------------
| Dutugemunu College Old Students' Association — Site Content
|--------------------------------------------------------------------------
|
| All editable copy for the public website lives here so the Blade views
| stay presentational. Update names, dates and figures in this one file.
|
| NOTE: sample figures (member counts, branch numbers, news items, committee
| names) are placeholders — replace them with the Association's real data.
|
*/

return [

    'name'        => "Dutugemunu College Old Students' Association",
    'short_name'  => 'DCOSA',
    'college'     => 'Dutugemunu College',
    'location'    => 'Buttala',
    'motto'       => 'Be a lamp unto yourself',
    'motto_si'    => 'අත්ථ දීපා විහරථ',
    'founded'     => 1971,
    'oba_founded' => 2002,

    'contact' => [
        'address' => 'Dutugemunu College, Buttala, Monaragala District, Sri Lanka',
        'phone'   => '+94 55 227 3000',
        'email'   => 'info@dcosa.lk',
        'hours'   => 'Office open Monday–Friday, 9.00 a.m. – 4.00 p.m.',
    ],

    'social' => [
        'facebook'  => 'https://facebook.com/dutugemunucollege',
        'instagram' => 'https://instagram.com/',
        'youtube'   => 'https://youtube.com/',
        'linkedin'  => 'https://linkedin.com/',
    ],

    'stats' => [
        ['value' => '1971',   'label' => 'College founded'],
        ['value' => '2002',   'label' => 'Association founded'],
        ['value' => '2,400+', 'label' => 'Registered members'],
        ['value' => '6',      'label' => 'Branches & chapters'],
    ],

    // Shown on the member dashboard's "Current Funds" tab. Sample figures — edit via /admin/settings.
    // One-time seed only: creates the opening-balance rows in the `fund_transactions` table
    // on a fresh `db:seed` (see SiteContentSeeder::seedFundTransactions()). After that,
    // funds are managed entirely at /admin/funds — editing this array again does nothing
    // once the table already has rows in it.
    'funds' => [
        'as_of'     => '2026-08-01',
        'breakdown' => [
            ['label' => 'Scholarship Fund',            'value' => 1850000],
            ['label' => 'Building & Development Fund', 'value' => 1600000],
            ['label' => 'General Fund',                'value' => 900000],
            ['label' => 'Welfare Fund',                'value' => 500000],
        ],
    ],

    // Shown on the member dashboard's "Donations" tab. Sample figures — edit via /admin/settings.
    'donations' => [
        'intro'          => 'Every rupee you give goes directly to scholarships, campus facilities and welfare projects. A direct bank transfer is the easiest way to contribute — please use your full name as the payment reference so we can issue a receipt.',
        'bank_name'      => 'Bank of Ceylon',
        'account_name'   => "Dutugemunu College Old Students' Association",
        'account_number' => '0123456789',
        'branch'         => 'Buttala',
    ],

    // Shown on the public "Downloads" page. Each 'file' is relative to /public.
    'downloads' => [
        [
            'title'       => 'Association Constitution',
            'description' => "The original constitution of the Dutugemunu College Old Students' Association (ව්‍යවස්ථාව), as adopted by the general membership.",
            'file'        => 'docs/les.pdf',
        ],
        [
            'title'       => 'Membership Application Form',
            'description' => 'The official paper application form for new membership. Print it, fill it in and hand it to the Secretary — or use the online form instead.',
            'file'        => 'docs/Dutugemunu Old St.pdf',
        ],
    ],

    'president_message' => [
        'name'   => 'Chandana Dissanayake',
        'title'  => 'Vice Chairman of the Association',
        'batch'  => '',
        'photo'  => 'commitie/chandana-dissanayake.jpeg',
        'body'   => [
            "It is an honour to step into the role of Vice Chairman of the Dutugemunu Central College Old Students' Association. As I take on this responsibility, my primary goal is to unite our incredible global alumni network to uplift our beloved alma mater and pave a brighter path for the next generation.",
            "Our school shaped who we are today. Now it is our turn to give back. I firmly believe that if we stand together, we can achieve our goals with ease. Great things happen when a community unites around a shared vision, and our collective strength can transform the educational landscape for current and future students.",
            "We are preparing to invest deeply in our young generation — their education, skills, sports and infrastructure. Your experience, resources and ideas are vital to making this happen. Whether you left recently or decades ago, your connection to Dutugemunu Central College remains invaluable.",
            "Join us today. Let's reconnect, collaborate, and build a lasting legacy for our school.",
        ],
    ],

    'quick_actions' => [
        [
            'title' => 'Become a Member',
            'text'  => 'Join fellow old students of Dutugemunu College and support the school that shaped you.',
            'icon'  => 'card',
            'url'   => '/join',
            'cta'   => 'Membership details',
        ],
        [
            'title' => 'Upcoming Events',
            'text'  => 'The Annual Dinner, reunions and Founders\' Day — see what is coming up.',
            'icon'  => 'calendar',
            'url'   => '/news#events',
            'cta'   => 'View calendar',
        ],
        [
            'title' => 'Association News',
            'text'  => 'Announcements, project updates and the achievements of old students.',
            'icon'  => 'news',
            'url'   => '/news',
            'cta'   => 'Read the latest',
        ],
        [
            'title' => 'Support a Project',
            'text'  => 'Fund a scholarship or contribute to the college development drive.',
            'icon'  => 'heart',
            'url'   => '/contact',
            'cta'   => 'Get in touch',
        ],
    ],

    'news' => [
        [
            'slug'  => 'annual-general-meeting-2026',
            'date'  => '2026-08-18',
            'tag'   => 'Announcement',
            'title' => '55th Annual General Meeting concludes with a new committee',
            'image' => 'images/news/agm.svg',
            'excerpt' => 'Members gathered at the College Main Hall to review the year, adopt the audited accounts and elect the office bearers for 2026/27.',
            'body' => [
                "The 55th Annual General Meeting of the Dutugemunu College Old Students' Association was held on 16 August 2026 at the College Main Hall, Buttala, with more than 200 members in attendance.",
                "The outgoing committee presented the annual report and the audited statement of accounts, both of which were adopted unanimously. Members noted with satisfaction that the Scholarship Fund had supported 32 students during the year.",
                "A new committee was elected for the 2026/27 term. The incoming President, Mr. Sunil Wickramasinghe, thanked the membership for their confidence and outlined three priorities for the year: the library modernisation project, expansion of the mentoring programme, and a renewed membership drive.",
            ],
        ],
        [
            'slug'  => 'science-lab-project-handover',
            'date'  => '2026-07-02',
            'tag'   => 'Projects',
            'title' => 'Association hands over refurbished science laboratory',
            'image' => 'images/news/lab.svg',
            'excerpt' => 'The Rs. 2.4 million refurbishment adds new benches, storage and safety equipment for Advanced Level students.',
            'body' => [
                "After eight months of work, the Association formally handed over the refurbished science laboratory to the Principal at a ceremony attended by staff, students and donors.",
                "The project — funded by old students, including a substantial contribution from the Class of 1996 — replaced ageing benches, improved the electrical supply and provided a full set of safety equipment.",
                "The Principal thanked the Association and noted that the facility would directly benefit more than 180 Advanced Level students each year.",
            ],
        ],
        [
            'slug'  => 'old-students-cricket-encounter',
            'date'  => '2026-06-15',
            'tag'   => 'Sports',
            'title' => "Old Students' XI edges past the College First XI in annual encounter",
            'image' => 'images/news/cricket.svg',
            'excerpt' => 'A friendly limited-overs match at the college grounds raised funds for the sports equipment fund.',
            'body' => [
                "The annual cricket encounter between the Old Students' XI and the College First XI was played in fine spirit at the college grounds, with the old students winning by 12 runs in a closely fought match.",
                "Proceeds from the day were directed to the sports equipment fund, which will provide new kit for the under-15 and under-17 teams.",
            ],
        ],
        [
            'slug'  => 'mentoring-programme-launch',
            'date'  => '2026-05-20',
            'tag'   => 'Community',
            'title' => 'Career mentoring programme pairs old students with A/L students',
            'image' => 'images/news/mentoring.svg',
            'excerpt' => 'Volunteers from fields ranging from medicine to agriculture have signed up for the first cohort.',
            'body' => [
                "The Association has launched a structured career mentoring programme connecting current Advanced Level students with old students working in their fields of interest.",
                "Volunteers have joined the first cohort, covering medicine, engineering, agriculture, teaching, the public service and entrepreneurship. Each mentor is paired with two students for monthly sessions across the academic year.",
            ],
        ],
    ],

    'events' => [
        [
            'date'     => '2026-10-04',
            'title'    => 'Committee Briefing for Members 2026/27',
            'location' => 'College Main Hall, Buttala',
            'time'     => '9.30 a.m.',
            'text'     => 'Open session for members to meet the new committee and hear the plans for the year.',
        ],
        [
            'date'     => '2026-11-21',
            'title'    => "Old Students' Annual Dinner & Awards Night",
            'location' => 'Monaragala',
            'time'     => '7.00 p.m.',
            'text'     => 'Our flagship social evening, with the presentation of the Distinguished Old Student award and long-service honours.',
        ],
        [
            'date'     => '2027-01-17',
            'title'    => "Founders' Day Commemoration & Almsgiving",
            'location' => 'College Premises',
            'time'     => '7.30 a.m.',
            'text'     => 'A religious observance and breakfast to mark the founding of the college.',
        ],
        [
            'date'     => '2027-03-13',
            'title'    => 'Colombo Chapter Reunion Lunch',
            'location' => 'Colombo',
            'time'     => 'From 12.00 noon',
            'text'     => 'The annual gathering of old students living in and around the capital. Guests and families welcome.',
        ],
    ],

    'past_events' => [
        ['date' => '2026-08-16', 'title' => "55th Annual General Meeting", 'text' => 'Held at the College Main Hall with 200+ members present.'],
        ['date' => '2026-05-30', 'title' => 'Family Fun Day & Fair', 'text' => 'A day of games, food stalls and music that raised funds for the library project.'],
        ['date' => '2026-04-12', 'title' => 'Colombo Chapter Get-Together', 'text' => 'Over 60 old students and families gathered in the capital.'],
    ],

    'committee' => [
        'office_bearers' => [
            ['role' => 'Chief Patron',        'name' => 'D. M. Kalupahana',            'photo' => 'commitie/dmkalupahana.jpeg'],
            ['role' => 'Chairman',            'name' => 'The Principal',               'photo' => 'commitie/principal.jpeg'],
            ['role' => 'Vice Chairman',       'name' => 'D. M. D. C. Dissanayake',     'photo' => 'commitie/chandana-dissanayake.jpeg'],
            ['role' => 'Secretary',           'name' => 'M. B. Chandana',              'photo' => 'commitie/chandana.jpeg'],
            ['role' => 'Assistant Secretary', 'name' => 'L. G. Dinuka Priyadarshani',  'photo' => 'commitie/dinuka.jpeg'],
            ['role' => 'Treasurer',           'name' => 'P. B. D. N. S. de Silva',     'photo' => 'commitie/bgng-silva.jpeg'],
            ['role' => 'Chief Organizer',     'name' => 'Jagath Abeysuriya',           'photo' => 'commitie/jagath.jpeg'],
            ['role' => 'Media Secretary',     'name' => 'Nadun Anupama',               'photo' => 'commitie/nadun.jpeg'],
        ],
        'members' => [
            ['name' => 'Suneth Kalupahana',               'photo' => 'commitie/suneth.jpeg'],
            ['name' => 'A. A. Manjula Amarasinghe',       'photo' => 'images/people/m1.svg'],
            ['name' => 'Indika Waragoda',                'photo' => 'commitie/indika.jpeg'],
            ['name' => 'Sanath Susantha',               'photo' => 'images/people/m2.svg'],
            ['name' => 'Anuradha Madhuwanthi',           'photo' => 'images/people/m3.svg'],
            ['name' => 'S. M. S. Harshana',              'photo' => 'commitie/sms-harshana.jpeg'],
            ['name' => 'P. M. Suresh Piyankara Bandara',  'photo' => 'images/people/m4.svg'],
            ['name' => 'G. L. Manula Liyanage',          'photo' => 'images/people/m5.svg'],
            ['name' => 'Manjula Sanjeewa',              'photo' => 'images/people/m6.svg'],
        ],
        'sub_committees' => [
            ['name' => 'Education & Scholarships', 'text' => 'Administers the Scholarship Fund and the bursary scheme for students in need.'],
            ['name' => 'Buildings & Development',  'text' => 'Plans and delivers infrastructure projects in partnership with the college administration.'],
            ['name' => 'Sports',                   'text' => 'Supports college teams and organises old students\' fixtures and the annual encounter.'],
            ['name' => 'Social & Events',          'text' => 'Runs the Annual Dinner, reunions, the Family Fun Day and chapter gatherings.'],
            ['name' => 'Membership & Chapters',    'text' => 'Grows the membership and coordinates the local and overseas chapters.'],
            ['name' => 'Media & Communications',   'text' => 'Publishes the newsletter, manages the website and social media channels.'],
        ],
    ],

    // Real names/terms not yet supplied — left empty rather than showing invented ones.
    // Add entries here (or once a "Past Presidents" admin/DB feature exists) as
    // ['name' => '...', 'years' => '...'].
    'past_presidents' => [],

    'history' => [
        ['year' => '2002', 'text' => 'Started with around 12 officers, established under the leadership of Mr. Dayananda.'],
        ['year' => '2003', 'text' => 'The board of officers was appointed, with Mr. Nishantha appointed as Vice President. An office was established during the Primary Grade 1 admissions.'],
        ['year' => '2004', 'text' => 'Increased membership by 20% and conducted an astronomy program for the children.'],
        ['year' => '2005', 'text' => 'Supported the school House Meet and assisted students participating in all-island sports competitions.'],
        ['year' => '2007', 'text' => 'Built the lower teachers\' rest room at the school and provided financial support for the arts festival.'],
        ['year' => '2015', 'text' => 'Revised the constitution and addressed structural shortcomings within the association.'],
        ['year' => '2020', 'text' => 'Organized the Dutugemunu Centenary Celebration and laid the foundation to re-engage alumni.'],
        ['year' => '2025', 'text' => 'An interim committee of Dutugemunu College alumni was appointed.'],
        ['year' => '2026', 'text' => 'A new committee was appointed for Dutugemunu College, establishing a transparent process by launching a website and digitizing all transactions.'],
    ],

    'objectives' => [
        'To foster fellowship and lifelong connection among past pupils of Dutugemunu College.',
        'To support the college in advancing the education and welfare of its students.',
        'To fund scholarships, bursaries and facilities that widen opportunity.',
        'To uphold the name, traditions and values of the college.',
        'To assist members and their families in times of need.',
    ],

    'notable_alumni' => [
        ['name' => 'Justice A. Samarakoon', 'field' => 'Judiciary',  'note' => 'Former Judge of the Court of Appeal'],
        ['name' => 'Prof. M. Ratnayake',    'field' => 'Academia',   'note' => 'Professor of Agriculture, University of Ruhuna'],
        ['name' => 'Dr. S. Iqbal',          'field' => 'Medicine',   'note' => 'Consultant physician and public-health advocate'],
        ['name' => 'Mr. T. Abeywardena',    'field' => 'Business',   'note' => 'Founder of a regional agri-business group'],
        ['name' => 'Mr. R. Peiris',         'field' => 'Sport',      'note' => 'Former first-class cricketer'],
        ['name' => 'Mr. K. Wijeratne',      'field' => 'Public Service', 'note' => 'Retired Government Agent, Monaragala District'],
    ],

    'faqs' => [
        ['q' => 'Who can join the Association?', 'a' => 'Any past pupil of Dutugemunu College, Buttala who has left the school is eligible for membership. Former members of staff may join as associate members.'],
        ['q' => 'How much is membership?', 'a' => 'Life membership is a one-time payment. The current rate and the application form are available from the Secretary — please use the contact form and we will send the details.'],
        ['q' => 'I live away from Buttala. Can I still take part?', 'a' => 'Yes. We have chapters in Colombo and overseas, and members everywhere. Contact us and we will connect you with the group nearest to you.'],
        ['q' => 'How are donations used?', 'a' => 'Every rupee goes to college projects and student welfare. The audited accounts are presented to members at the Annual General Meeting each year.'],
    ],
];
