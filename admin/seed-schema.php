<?php
// ================================================================
//  Schema Seeder — Homecare Creators
//  Visit /admin/seed-schema.php?run=1  to execute.
//  DELETE THIS FILE after running!
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
hc_require_auth();

// ── helpers ──────────────────────────────────────────────────────
function add_schema(string $page_path, string $type, array $data): void {
    hc_q("INSERT INTO hc_page_schema (page_path,schema_type,schema_data,active) VALUES (?,?,?,1)",
        [$page_path, $type, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)]);
}

function faq(array $pairs): array {
    return ['mainEntity' => array_map(fn($q) => [
        '@type' => 'Question', 'name' => $q[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q[1]]
    ], $pairs)];
}

function bc(array $items): array {
    $out = [];
    $i   = 1;
    foreach ($items as [$name, $url]) {
        $out[] = ['@type'=>'ListItem','position'=>$i++,'name'=>$name,'item'=>$url];
    }
    return ['itemListElement' => $out];
}

const SITE  = 'https://homecarecreators.com';
const ORG   = 'Homecare Creators';
const EMAIL = 'info@homecarecreators.com';
const PHONE = '+1-409-419-3533';
const ADDR  = ['@type'=>'PostalAddress',
               'addressLocality'=>'Lady Lake','addressRegion'=>'FL','postalCode'=>'32159','addressCountry'=>'US'];
const FOUNDER = ['@type'=>'Person','name'=>'Asifa Rani','jobTitle'=>'Founder & CEO','url'=>'https://homecarecreators.com/about/','sameAs'=>['https://www.linkedin.com/in/asifa-rani/']];

// ── City data: path => city info ─────────────────────────────────
// Paths match $page_canonical (domain stripped) from each actual page file.
$mkt_cities = [
    '/home-care-agency-seo-miami-fl/'          => ['name'=>'Miami',          'county'=>'Miami-Dade',  'pop'=>'over 478,000 seniors in the metro area'],
    '/home-care-agency-seo-tampa-fl/'          => ['name'=>'Tampa',           'county'=>'Hillsborough','pop'=>'over 320,000 seniors in Hillsborough County'],
    '/home-care-agency-seo-jacksonville-fl/'   => ['name'=>'Jacksonville',    'county'=>'Duval',       'pop'=>'over 200,000 seniors in the metro'],
    '/home-care-agency-seo-clearwater-fl/'     => ['name'=>'Clearwater',      'county'=>'Pinellas',   'pop'=>'a county with one of the oldest median ages in Florida'],
    '/home-care-agency-seo-west-palm-beach-fl/'=> ['name'=>'West Palm Beach', 'county'=>'Palm Beach', 'pop'=>'over 280,000 seniors in Palm Beach County'],
    '/home-care-agency-seo-sarasota-fl/'       => ['name'=>'Sarasota',        'county'=>'Sarasota',   'pop'=>'over 30% of residents aged 65 or older'],
    '/home-care-agency-seo-fort-lauderdale-fl/'=> ['name'=>'Fort Lauderdale', 'county'=>'Broward',    'pop'=>'over 350,000 seniors in Broward County'],
    '/home-care-agency-seo-naples-fl/'         => ['name'=>'Naples',          'county'=>'Collier',    'pop'=>'one of the highest senior-per-capita ratios in the United States'],
    '/home-care-agency-seo-boca-raton-fl/'     => ['name'=>'Boca Raton',      'county'=>'Palm Beach', 'pop'=>'a high concentration of affluent retirees and senior residents'],
    '/home-care-agency-seo-orlando-fl/'        => ['name'=>'Orlando',         'county'=>'Orange',     'pop'=>'over 280,000 seniors in the greater metro area'],
];

$wd_cities = [
    '/homecare-website-design-miami-fl/'          => ['name'=>'Miami',           'county'=>'Miami-Dade'],
    '/homecare-website-design-tampa-fl/'          => ['name'=>'Tampa',           'county'=>'Hillsborough'],
    '/homecare-website-design-orlando-fl/'        => ['name'=>'Orlando',         'county'=>'Orange'],
    '/homecare-website-design-jacksonville-fl/'   => ['name'=>'Jacksonville',    'county'=>'Duval'],
    '/homecare-website-design-fort-lauderdale-fl/'=> ['name'=>'Fort Lauderdale', 'county'=>'Broward'],
    '/homecare-website-design-naples-fl/'         => ['name'=>'Naples',          'county'=>'Collier'],
];

$run = isset($_GET['run']);
$log = [];

if ($run) {
    hc_q("TRUNCATE TABLE hc_page_schema");

    // ════════════════════════════════════════════════════════════
    //  HOMEPAGE  /
    // ════════════════════════════════════════════════════════════
    add_schema('/', 'MarketingAgency', [
        'name'        => ORG,
        'description' => 'Homecare Creators is a digital marketing agency built exclusively for home care agencies in Florida. We specialize in local SEO, Google Maps optimization, custom website design, and AI search visibility — helping homecare businesses attract more private-pay and Medicaid clients.',
        'url'         => SITE,
        'telephone'   => PHONE,
        'email'       => EMAIL,
        'foundingDate'=> '2026',
        'founder'     => FOUNDER,
        'address'     => ADDR,
        'areaServed'  => [['@type'=>'State','name'=>'Florida'],['@type'=>'Country','name'=>'United States']],
        'serviceArea' => ['@type'=>'State','name'=>'Florida'],
        'slogan'      => 'Market It. Manage It. Grow It. — Built Exclusively for Homecare.',
        'knowsAbout'  => ['Home Care Marketing','Local SEO','Homecare Website Design','AI Search Optimization','GEO — Generative Engine Optimization','Google Maps Ranking for Home Care'],
        'hasOfferCatalog' => ['@type'=>'OfferCatalog','name'=>'Homecare Marketing Services','itemListElement'=>[
            ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Local SEO for Home Care Agencies']],
            ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Homecare Website Design']],
            ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'AI Search & GEO Optimization']],
            ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Google Maps 3-Pack Ranking']],
        ]],
        'sameAs' => ['https://www.linkedin.com/company/homecare-creators/'],
    ]);
    $log[] = '✓ / → MarketingAgency';

    // ════════════════════════════════════════════════════════════
    //  ABOUT PAGE — Founder / Person schema
    // ════════════════════════════════════════════════════════════
    add_schema('/about/', 'AboutPage', [
        'name'        => 'About Homecare Creators',
        'url'         => SITE.'/about/',
        'mainEntity'  => array_merge(FOUNDER, [
            'worksFor'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
            'telephone'   => PHONE,
            'email'       => EMAIL,
            'address'     => ADDR,
            'description' => 'Asifa Rani is the Founder & CEO of Homecare Creators, a marketing agency built exclusively for home care agencies. Before Homecare Creators, she co-founded a web solutions company helping businesses build their digital presence.',
        ]),
    ]);
    $log[] = '✓ /about/ → AboutPage + Person (founder)';

    add_schema('/about/', 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['About', SITE.'/about/']
    ]));
    $log[] = '✓ /about/ → BreadcrumbList';

    // ════════════════════════════════════════════════════════════
    //  CONTACT PAGE
    // ════════════════════════════════════════════════════════════
    add_schema('/contact/', 'ContactPage', [
        'name'        => 'Contact Homecare Creators',
        'url'         => SITE.'/contact/',
        'mainEntity'  => ['@type'=>'Organization','name'=>ORG,'telephone'=>PHONE,'email'=>EMAIL,'address'=>ADDR],
    ]);
    $log[] = '✓ /contact/ → ContactPage';

    add_schema('/contact/', 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['Contact', SITE.'/contact/']
    ]));
    $log[] = '✓ /contact/ → BreadcrumbList';

    add_schema('/', 'WebSite', [
        'name'        => ORG,
        'url'         => SITE,
        'description' => "A Florida marketing agency built exclusively for home care agencies.",
        'potentialAction' => ['@type'=>'SearchAction','target'=>['@type'=>'EntryPoint','urlTemplate'=>SITE.'/blog?s={search_term_string}'],'query-input'=>'required name=search_term_string'],
        'inLanguage'  => 'en-US',
    ]);
    $log[] = '✓ / → WebSite';

    add_schema('/', 'FAQPage', faq([
        ['What does a homecare marketing agency do?', 'A homecare marketing agency helps home care businesses attract more clients through local SEO, Google Maps optimization, website design, and AI search visibility. Unlike general marketing agencies, a specialized homecare agency understands private-pay vs. Medicaid client acquisition, the search behavior of families looking for care, and what compels a senior or adult child to call one agency over another — delivering faster, more targeted results.'],
        ['How long does homecare SEO take to show results?', 'Most homecare agencies see measurable ranking improvements within 60 to 90 days. Google Maps visibility often improves within 4 to 6 weeks. Significant organic lead increases typically occur between months 4 and 6. Timeline depends on current website authority, local competition level, and the consistency of ongoing optimization efforts.'],
        ['How much does SEO cost for a home care agency?', 'Homecare SEO services range from $800 to $3,000 per month depending on cities targeted, competition level, and services included. Packages typically start with local SEO for a single market and scale to full multi-city campaigns with website design, content creation, and AI search optimization included.'],
        ['Why is local SEO critical for home care agencies?', 'Over 80% of families searching for home care use Google to find local providers. If your agency doesn\'t appear on page 1 — especially in the Google Maps 3-pack — you\'re invisible to the majority of potential clients. Local SEO ensures your agency shows up when families in your service area search for home care, elder care, or in-home assistance.'],
        ['How do I get my home care agency to rank on Google Maps?', 'Ranking on Google Maps requires a fully optimized Google Business Profile, consistent NAP citations across directories, genuine client reviews (15+ with a 4.5+ rating), and location-specific pages on your website. Proximity to the searcher, keyword relevance in your profile, and your website domain authority all directly influence your Maps 3-pack position.'],
        ['What is the difference between homecare SEO and regular SEO?', 'Homecare SEO targets keywords, search intent, and geographic signals used by families looking for elder care and in-home assistance. It requires understanding of care-industry competitors including national franchises, local service area targeting, and review strategies suited to the care industry — expertise that most general agencies lack.'],
        ['Can AI search tools like ChatGPT send clients to my home care agency?', 'Yes — increasingly. AI tools including ChatGPT, Google AI Overviews, and Perplexity cite local businesses in their answers. To appear in AI-generated results, your agency needs structured FAQ schema, authoritative local content, a strong entity footprint, and consistent citations across the web. This growing channel is called GEO (Generative Engine Optimization).'],
        ['Do home care agencies need a professional website?', 'Absolutely. Your website is your most important marketing asset. Families researching home care judge credibility heavily by website quality — a poor site signals an unprofessional agency. A professional homecare website must load fast on mobile, clearly explain services and coverage areas, include trust signals like licenses and testimonials, and be optimized for local search.'],
        ['How do I attract more private-pay clients to my home care agency?', 'Attracting private-pay clients requires ranking for high-intent search terms like "home care agency near me" and "private duty home care [city]," combined with a website that builds trust. Key strategies include local SEO, Google Maps optimization, professional website design, active review generation, and content targeting adult children researching care for aging parents.'],
        ['Which Florida cities have the strongest demand for home care?', "Florida's highest-demand homecare markets include Miami, Tampa, Fort Lauderdale, Sarasota, Naples, Jacksonville, Boca Raton, and The Villages — which has 57% of its population aged 65+. With Florida ranking last nationally in home health aide availability relative to need, every major metro has far more demand than supply, making effective marketing the single biggest growth lever for Florida homecare agencies."],
    ]));
    $log[] = '✓ / → FAQPage (10 questions)';

    // Note: the former "Local SEO for Home Care Agencies" page
    // (/local-seo-for-home-care-agencies/) was retired and 301-redirected
    // into /seo/home-care-seo/ to resolve keyword cannibalization — that
    // page now carries its own schema inline (see seo/home-care-seo/index.php),
    // so no seeder entry is needed for it here.

    // ════════════════════════════════════════════════════════════
    //  WEBSITE DESIGN SERVICE PAGE
    // ════════════════════════════════════════════════════════════
    $p = '/web-design/homecare-website-design/';
    add_schema($p, 'Service', [
        'name'        => 'Homecare Agency Website Design',
        'description' => 'Custom website design and development for home care agencies in Florida. We build fast, mobile-first, SEO-optimized websites that establish trust with families, convert visitors into inquiries, and rank on Google — engineered specifically for homecare agency owners who need results, not templates.',
        'provider'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
        'serviceType' => 'Website Design and Development',
        'areaServed'  => ['@type'=>'State','name'=>'Florida'],
        'url'         => SITE.$p,
        'category'    => 'Web Design',
        'audience'    => ['@type'=>'Audience','audienceType'=>'Home Care Agency Owners in Florida'],
        'offers'      => ['@type'=>'Offer','description'=>'Custom homecare website design — SEO-ready, mobile-first, delivered in 3–5 weeks.','priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'],
    ]);
    $log[] = '✓ '.$p.' → Service';

    add_schema($p, 'FAQPage', faq([
        ['What should a homecare agency website include?', 'An effective homecare website must include: a homepage clearly stating services and coverage areas, individual pages for each care service (personal care, companionship, Alzheimer\'s care, etc.), a dedicated city page for each location served, client testimonials, caregiver profiles, your Florida homecare license number, and a visible contact form or phone number on every page. Speed and mobile performance are non-negotiable.'],
        ['How much does a homecare website design cost?', 'Professional homecare website design ranges from $2,500 to $8,000 for a custom build. Basic template sites start around $1,500 but rarely rank well on Google. A full package includes custom design, copywriting for core pages, local SEO optimization, and Google Analytics setup — delivered in 3 to 5 weeks.'],
        ['How long does it take to build a homecare website?', 'A professionally built homecare website typically takes 3 to 5 weeks from kickoff to launch, including design, content writing, SEO optimization, mobile testing, and revision rounds. The timeline depends largely on how quickly the agency provides their logo, photos, and content feedback. Rush builds in 2 weeks are available for agencies with urgent launch deadlines.'],
        ['Is mobile optimization important for homecare websites?', 'Critically important. Over 70% of families searching for home care do so on a mobile device — often in a stressful moment when a parent needs immediate care. A slow or hard-to-navigate mobile site loses these high-intent visitors immediately. Google also uses mobile performance as a primary ranking signal, so poor mobile design is a direct liability for your search rankings.'],
        ['What makes a homecare website rank on Google?', 'A homecare website ranks through: technical performance (fast load times, clean code, mobile-first), on-page SEO (location-specific titles, meta descriptions, schema markup), local authority (Google Business Profile, consistent citations), and content depth (service pages, city pages, and blog posts targeting local homecare keywords in your service area).'],
        ['Do home care agencies need city-specific pages on their website?', 'Yes — if you serve multiple cities, dedicated city pages are essential. A page optimized for "home care agency in Tampa" can independently rank for Tampa searches. Agencies with city-specific content consistently outrank competitors across their entire service area in both Google Maps and organic results.'],
    ]));
    $log[] = '✓ '.$p.' → FAQPage (6 questions)';

    add_schema($p, 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['Homecare Website Design', SITE.$p]
    ]));
    $log[] = '✓ '.$p.' → BreadcrumbList';

    // ════════════════════════════════════════════════════════════
    //  MARKETING CITY PAGES  (10 cities)
    // ════════════════════════════════════════════════════════════
    foreach ($mkt_cities as $path => $city) {
        $c   = $city['name'];
        $co  = $city['county'];
        $pop = $city['pop'];
        $url = SITE.$path;

        add_schema($path, 'LocalBusiness', [
            'name'        => ORG,
            'description' => "Homecare Creators provides expert digital marketing for home care agencies in {$c}, Florida — including local SEO, Google Maps optimization, and website design to help {$c} homecare businesses attract more private-pay and Medicaid clients.",
            'url'         => $url,
            'telephone'   => PHONE,
            'email'       => EMAIL,
            'address'     => ADDR,
            'areaServed'  => [
                ['@type'=>'City','name'=>$c,'containedInPlace'=>['@type'=>'State','name'=>'Florida']],
                ['@type'=>'County','name'=>"{$co} County",'containedInPlace'=>['@type'=>'State','name'=>'Florida']],
            ],
            'serviceArea' => ['@type'=>'City','name'=>$c,'addressRegion'=>'FL'],
            'priceRange'  => '$$',
        ]);
        $log[] = "✓ {$path} → LocalBusiness";

        add_schema($path, 'Service', [
            'name'        => "Home Care Agency Marketing in {$c}, FL",
            'description' => "Full-service digital marketing for home care agencies in {$c}, Florida — local SEO, Google Maps 3-pack ranking, website design, and AI search visibility targeting families searching for home care in {$c} and {$co} County.",
            'provider'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
            'serviceType' => 'Home Care Agency Digital Marketing',
            'areaServed'  => ['@type'=>'City','name'=>$c,'addressRegion'=>'FL'],
            'url'         => $url,
            'audience'    => ['@type'=>'Audience','audienceType'=>"Home Care Agency Owners in {$c}, FL"],
            'offers'      => ['@type'=>'Offer','priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'],
        ]);
        $log[] = "✓ {$path} → Service";

        add_schema($path, 'FAQPage', faq([
            ["How do I market my home care agency in {$c}, FL?", "Marketing a home care agency in {$c} requires a local-first strategy: fully optimize your Google Business Profile for {$c}, build location-specific web pages targeting 'home care agency {$c},' generate genuine reviews from local clients, and build citations in {$c}-area directories. {$c} has {$pop}, creating strong ongoing demand for professional homecare marketing."],
            ["How competitive is the home care market in {$c}, Florida?", "The {$c} market is active and growing — with {$pop}. While national franchises (Comfort Keepers, BrightSpring, Home Instead) compete for visibility, local independent agencies consistently win by ranking for hyperlocal keywords, building genuine community trust, and maintaining a strong Google Maps 3-pack presence. Agencies with focused local SEO typically dominate their priority ZIP codes within 6 months."],
            ["What does home care cost in {$c}, FL?", "Non-medical personal care in {$c}, Florida typically costs between \$22 and \$35 per hour. Specialized memory care or skilled nursing ranges from \$28 to \$45 per hour. Private-pay rates in {$co} County are among the higher tiers in Florida. Florida's Medicaid Long-Term Care Managed Care program can offset costs for eligible clients, creating a dual market of private-pay and Medicaid opportunities."],
            ["How do I rank on Google Maps for home care in {$c}?", "To rank in Google Maps for {$c}: fully complete your Google Business Profile with your service area, categories, photos, and services. Build 15+ verified reviews averaging 4.5+ stars, maintain consistent NAP citations across directories, and have {$c}-specific content on your website. A local SEO audit will identify the fastest ranking opportunities for your exact service area."],
            ["Is {$c} a good city to operate a home care agency?", "{$c} is an excellent market for homecare businesses, with {$pop}. Florida's favorable regulatory environment simplifies homecare licensing, the Medicaid Long-Term Care Managed Care program provides a stable referral pipeline, and the private-pay market is robust given Florida's large affluent retiree population — making {$c} one of the strongest homecare growth markets in the country."],
        ]));
        $log[] = "✓ {$path} → FAQPage (5 questions)";

        add_schema($path, 'BreadcrumbList', bc([
            ['Home', SITE.'/'], ['Home Care Agency SEO', SITE.'/seo/home-care-seo/'], ["{$c} Home Care Agency SEO", $url]
        ]));
        $log[] = "✓ {$path} → BreadcrumbList";
    }

    // ════════════════════════════════════════════════════════════
    //  WEB-DESIGN CITY PAGES  (6 cities)
    // ════════════════════════════════════════════════════════════
    foreach ($wd_cities as $path => $city) {
        $c   = $city['name'];
        $co  = $city['county'];
        $url = SITE.$path;

        add_schema($path, 'Service', [
            'name'        => "Homecare Website Design in {$c}, FL",
            'description' => "Custom, SEO-optimized website design for home care agencies in {$c}, Florida. We build mobile-first, high-converting websites that rank on Google and turn visitors into client inquiries — designed specifically for {$c} homecare agency owners who want results from day one.",
            'provider'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
            'serviceType' => 'Website Design for Home Care Agencies',
            'areaServed'  => ['@type'=>'City','name'=>$c,'addressRegion'=>'FL'],
            'url'         => $url,
            'offers'      => ['@type'=>'Offer','priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'],
        ]);
        $log[] = "✓ {$path} → Service";

        add_schema($path, 'FAQPage', faq([
            ["Do home care agencies in {$c} need a professional website?", "In {$c}'s competitive home care market, a professional website is essential. Families research multiple agencies online before contacting anyone. A poorly designed website loses these high-intent visitors immediately — often to a competitor with a better site. A professional, fast-loading, mobile-optimized site with clear services and local trust signals is the foundation of every successful homecare marketing campaign in {$c}."],
            ["What should a homecare website serving {$c} include?", "A homecare website for the {$c} market should include: a homepage stating your service area and specialties, individual pages for each care service, a {$c}-specific location page with local keywords, testimonials from {$co} County families, your Florida homecare license number, caregiver profiles, and a prominent call/contact button visible on every page."],
            ["How much does homecare website design cost in {$c}, FL?", "Professional homecare website design in {$c} ranges from \$2,500 to \$8,000 for a fully custom, SEO-optimized build. A full package includes custom design, core page copywriting, local SEO optimization, Google Analytics setup, and mobile testing — delivered in 3 to 5 weeks with no long-term contracts required."],
            ["How long does it take to launch a homecare website in {$c}?", "From kickoff to launch, a professional homecare website for a {$c} agency typically takes 3 to 5 weeks. This includes design, content writing, SEO optimization, mobile testing, and revision rounds. The timeline accelerates when the agency promptly provides their logo, photos, and content feedback. Rush builds in 2 weeks are available for urgent launches."],
        ]));
        $log[] = "✓ {$path} → FAQPage (4 questions)";

        add_schema($path, 'BreadcrumbList', bc([
            ['Home', SITE.'/'], ['Website Design', SITE.'/web-design/homecare-website-design/'], ["{$c} Homecare Website Design", $url]
        ]));
        $log[] = "✓ {$path} → BreadcrumbList";
    }

    // ════════════════════════════════════════════════════════════
    //  AI SEARCH SEO SERVICE PAGE
    // ════════════════════════════════════════════════════════════
    $p = '/ai-search-seo/';
    add_schema($p, 'Service', [
        'name'        => 'AI Search SEO for Home Care Agencies',
        'description' => 'AI Search SEO (GEO/AEO) for home care agencies — structured data, entity building, and answer-formatted content built to help agencies get cited by ChatGPT, Google AI Overviews, and Perplexity.',
        'provider'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
        'serviceType' => 'Generative Engine Optimization (GEO) / Answer Engine Optimization (AEO)',
        'areaServed'  => ['@type'=>'State','name'=>'Florida'],
        'url'         => SITE.$p,
        'audience'    => ['@type'=>'Audience','audienceType'=>'Home Care Agency Owners'],
        'offers'      => ['@type'=>'Offer','priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'],
    ]);
    $log[] = '✓ '.$p.' → Service';

    add_schema($p, 'FAQPage', faq([
        ['What is AI Search SEO (GEO/AEO), exactly?', 'Generative Engine Optimization (GEO) and Answer Engine Optimization (AEO) are the practices of structuring your website and content so tools like ChatGPT, Google AI Overviews, and Perplexity can understand, trust, and cite your agency when a family asks for a home care recommendation. Think of it as the AI-era counterpart to traditional SEO, built around how these tools actually pull and summarize information.'],
        ['How is this different from regular local SEO?', "Traditional SEO is built around ranking a page in a list of results for specific keywords. AI search optimization leans much more heavily on structured data, entity consistency, clear direct-answer content, and third-party authority signals, since that's what a generative model relies on to decide what to summarize and who to cite. We run both together, since they reinforce each other rather than compete."],
        ['How long does it take to show up in AI answers?', "Honestly, there's no fixed timeline the way there is for something like Google Maps rankings, since this is such a new field. Most agencies see early signals, like being pulled into an AI Overview or referenced by a chatbot, within a few months of consistent work. But the AI platforms control their own models and update them on their own schedule, so visibility can shift as those models change, not just based on our work."],
        ['Do you guarantee my agency will be cited by ChatGPT?', "No, and we won't pretend otherwise. No agency can honestly guarantee a placement inside a system it doesn't control. What we do guarantee is the work itself: building the structured data, entity signals, and answer-formatted content that give your agency a real, defensible shot at being included. Every engagement is also backed by our standard 30-day satisfaction guarantee."],
        ["What's included in the AI Search SEO service?", 'AI Overviews and ChatGPT citation optimization, entity and knowledge graph building, FAQ schema and structured content, and a monthly AI visibility report showing what\'s changed. We also coordinate this work with your local SEO so both channels reinforce each other instead of working in isolation.'],
        ['Can this be bundled with local SEO or website design?', "Yes. Most agencies bundle AI Search SEO with local SEO and/or website design, since all three draw on the same technical foundation and content. If you're already a local SEO client, we can also add AI Search SEO on to your existing retainer."],
        ['Do you require a long-term contract?', 'No. Like the rest of our services, AI Search SEO starts with a 90-day ramp-up period so the foundational work, schema, entity data, and structured content, can be built properly. After that, everything moves to month-to-month.'],
    ]));
    $log[] = '✓ '.$p.' → FAQPage (7 questions)';

    add_schema($p, 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['AI Search SEO', SITE.$p]
    ]));
    $log[] = '✓ '.$p.' → BreadcrumbList';

    // ════════════════════════════════════════════════════════════
    //  AREAS WE SERVE HUB
    // ════════════════════════════════════════════════════════════
    $p = '/areas-we-serve/';
    add_schema($p, 'CollectionPage', [
        'name'        => 'Home Care Agency Marketing Across Florida',
        'description' => 'An overview of the Florida markets Homecare Creators serves, with links to each city-specific home care agency marketing page.',
        'url'         => SITE.$p,
    ]);
    $log[] = '✓ '.$p.' → CollectionPage';

    add_schema($p, 'FAQPage', faq([
        ['Do you only serve these 10 cities?', "No, these are our primary Florida markets but we work with agencies throughout the state. If your agency operates somewhere not listed above, reach out and we'll talk through how we'd build out a strategy and dedicated pages for your specific service area."],
        ['Why does each city have its own page instead of one page?', 'Every Florida market has different demographics, competition, and search behavior. A dedicated page lets us speak directly to that local market and helps your agency show up when families in that specific city search for home care.'],
        ['What if my agency serves more than one of these cities?', "That's common, and it's exactly what we plan for. We build out local SEO and, where needed, dedicated service-area pages for each city or county your agency actually operates in, not just one market."],
        ['How do I know which services are right for my market?', "Book a free audit and we'll review your current online presence, your specific city or county, and your competitors, then recommend a plan built around what your market actually needs."],
    ]));
    $log[] = '✓ '.$p.' → FAQPage (4 questions)';

    add_schema($p, 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['Areas We Serve', SITE.$p]
    ]));
    $log[] = '✓ '.$p.' → BreadcrumbList';

    // ════════════════════════════════════════════════════════════
    //  CAREOS
    // ════════════════════════════════════════════════════════════
    $p = '/careos/';
    add_schema($p, 'SoftwareApplication', [
        'name'            => 'CareOS',
        'description'     => 'CareOS is an AI-powered management platform for home care agencies — scheduling, billing, EVV compliance, voice journaling, and predictive intelligence in one login. Coming Q3 2026.',
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'Web',
        'url'             => SITE.$p,
        'publisher'       => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
    ]);
    $log[] = '✓ '.$p.' → SoftwareApplication';

    add_schema($p, 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['CareOS', SITE.$p]
    ]));
    $log[] = '✓ '.$p.' → BreadcrumbList';

    // ════════════════════════════════════════════════════════════
    //  ADJACENT VERTICAL PAGES  (5 verticals)
    // ════════════════════════════════════════════════════════════
    $verticals = [
        '/memory-care-marketing/' => [
            'name' => 'Memory Care Marketing', 'noun' => 'memory care communities',
            'faqs' => [
                ['How is marketing for memory care different from home care marketing?', "Memory care marketing has to speak directly to Alzheimer's and dementia-specific concerns: secured environments, specialized staff training, and safety, not general in-home assistance. Search intent is also more urgent, and trust signals like certifications and reviews carry more weight in a family's decision. We build your strategy and content around those differences rather than reusing generic senior care messaging."],
                ['How much does memory care marketing cost?', "Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on how competitive your local market is and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your community."],
                ['How long until we see results?', 'Timelines vary based on your starting point and how competitive your area is, but most communities begin seeing measurable movement in visibility and inquiries within the first few months as local SEO, content, and reputation work take hold. We report on progress every month so you always know where things stand.'],
                ['Do you require a long-term contract?', "No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract."],
                ['Can this be bundled with website design?', 'Yes. Most memory care clients bundle website design with SEO since the two work best together, but we also support communities who already have a site and just want SEO and AI search optimization managed.'],
                ['Can ChatGPT and Google AI recommend our memory care community to families?', "Yes, and it's a fast-growing channel. We optimize your site's structure, entity data, and FAQ content so AI tools like ChatGPT, Google AI Overviews, and Perplexity can accurately cite and recommend your community, not just traditional Google search."],
            ],
        ],
        '/hospice-marketing/' => [
            'name' => 'Hospice Marketing', 'noun' => 'hospice providers',
            'faqs' => [
                ['How is marketing for hospice different from home care marketing?', 'Hospice search intent is far more sensitive, and tone matters as much as ranking position. Hospice growth also depends heavily on referral relationships with hospitals, physicians, and discharge planners, alongside direct family search. We build strategy and content around both audiences, with a respectful, non-promotional voice throughout.'],
                ['How do you handle the sensitivity of hospice search terms?', 'Every piece of content is written and reviewed with tone in mind first. We avoid pressure tactics, aggressive calls to action, or anything that could feel dismissive of what a family is going through. The goal is always to inform and reassure.'],
                ['How much does hospice marketing cost?', "Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on your local market and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your organization."],
                ['How long until we see results?', 'Timelines vary based on your starting point and local competition, but most organizations see meaningful movement in visibility and inquiry volume within the first few months as SEO, content, and reputation work build up. We report on progress every month.'],
                ['Do you require a long-term contract?', "No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract."],
                ['Can this be bundled with website design?', 'Yes. Most hospice clients bundle website design with SEO since the two work best together, but we also support organizations who already have a site and just want SEO and AI search optimization managed.'],
            ],
        ],
        '/nursing-home-marketing/' => [
            'name' => 'Nursing Home Marketing', 'noun' => 'nursing homes and skilled nursing facilities',
            'faqs' => [
                ['How is marketing for nursing homes different from home care marketing?', 'Nursing home marketing has to account for CMS star ratings appearing alongside your listing, a referral pipeline that includes hospital discharge planners and case managers, and a more regulated content environment. We build strategy and messaging specifically around those realities rather than treating your facility like a home care agency.'],
                ['Do you help with CMS star ratings directly?', "We don't manage the CMS survey or rating process itself, but we do build website content and review strategies that present your quality-of-care story clearly to families who are researching ratings alongside your online presence."],
                ['How much does nursing home marketing cost?', "Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on your local market and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your facility."],
                ['How long until we see results?', 'Timelines vary based on your starting point and local competition, but most facilities see measurable movement in visibility and inquiry volume within the first few months as SEO, content, and reputation work build up. We report on progress every month.'],
                ['Do you require a long-term contract?', "No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract."],
                ['Can this be bundled with website design?', 'Yes. Most nursing home clients bundle website design with SEO since the two work best together, but we also support facilities who already have a site and just want SEO and AI search optimization managed.'],
            ],
        ],
        '/senior-living-marketing/' => [
            'name' => 'Senior Living Marketing', 'noun' => 'independent and retirement living communities',
            'faqs' => [
                ['How is marketing for senior living different from home care marketing?', 'Senior living marketing sells a lifestyle and a community as much as a care level: amenities, dining, activities, and floor plans matter as much as any care service. Prospects also typically compare several communities before booking a single tour, so the content and conversion path need to be built around comparison shopping and tour bookings, not just inquiries.'],
                ['How much does senior living marketing cost?', "Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on how competitive your local market is and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your community."],
                ['How long until we see results?', 'Timelines vary based on your starting point and how competitive your area is, but most communities begin seeing measurable movement in visibility and tour requests within the first few months as local SEO, content, and reputation work take hold. We report on progress every month so you always know where things stand.'],
                ['Do you require a long-term contract?', "No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract."],
                ['Can this be bundled with website design?', 'Yes. Most senior living clients bundle website design with SEO since the two work best together, but we also support communities who already have a site and just want SEO and AI search optimization managed.'],
                ['Can ChatGPT and Google AI recommend our community to prospects?', "Yes, and it's a fast-growing channel. We optimize your site's structure, entity data, and FAQ content so AI tools like ChatGPT, Google AI Overviews, and Perplexity can accurately cite and recommend your community, not just traditional Google search."],
            ],
        ],
        '/assisted-living-marketing/' => [
            'name' => 'Assisted Living Marketing', 'noun' => 'assisted living communities',
            'faqs' => [
                ['How is marketing for assisted living different from home care marketing?', 'Assisted living marketing has to balance independence and support messaging clearly, since families are comparing a community lifestyle alongside a level of care. Prospects also typically compare several communities on cost and care level before booking a tour, so the site and content need to be built around that side-by-side comparison, not just an inquiry form.'],
                ['How much does assisted living marketing cost?', "Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on how competitive your local market is and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your community."],
                ['How long until we see results?', 'Timelines vary based on your starting point and how competitive your area is, but most communities begin seeing measurable movement in visibility and tour requests within the first few months as local SEO, content, and reputation work take hold. We report on progress every month so you always know where things stand.'],
                ['Do you require a long-term contract?', "No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract."],
                ['Can this be bundled with website design?', 'Yes. Most assisted living clients bundle website design with SEO since the two work best together, but we also support communities who already have a site and just want SEO and AI search optimization managed.'],
                ['Can ChatGPT and Google AI recommend our community to families?', "Yes, and it's a fast-growing channel. We optimize your site's structure, entity data, and FAQ content so AI tools like ChatGPT, Google AI Overviews, and Perplexity can accurately cite and recommend your community, not just traditional Google search."],
            ],
        ],
    ];

    foreach ($verticals as $path => $v) {
        $url = SITE.$path;
        add_schema($path, 'Service', [
            'name'        => $v['name'],
            'description' => "Digital marketing built specifically for {$v['noun']} — local SEO, website design, and AI search optimization from an agency built exclusively for senior care.",
            'provider'    => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
            'serviceType' => $v['name'],
            'areaServed'  => ['@type'=>'State','name'=>'Florida'],
            'url'         => $url,
            'audience'    => ['@type'=>'Audience','audienceType'=>ucfirst($v['noun']).' operators'],
            'offers'      => ['@type'=>'Offer','priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'],
        ]);
        $log[] = "✓ {$path} → Service";

        add_schema($path, 'FAQPage', faq($v['faqs']));
        $log[] = "✓ {$path} → FAQPage (".count($v['faqs'])." questions)";

        add_schema($path, 'BreadcrumbList', bc([
            ['Home', SITE.'/'], [$v['name'], $url]
        ]));
        $log[] = "✓ {$path} → BreadcrumbList";
    }

    // ════════════════════════════════════════════════════════════
    //  BLOG INDEX
    // ════════════════════════════════════════════════════════════
    add_schema('/blog', 'Blog', [
        'name'        => 'Homecare Creators Marketing Blog',
        'description' => 'Expert guides, SEO strategies, and marketing insights for home care agency owners across Florida. Learn how to rank on Google, attract more clients, and grow your homecare business.',
        'url'         => SITE.'/blog',
        'publisher'   => ['@type'=>'Organization','name'=>ORG,'url'=>SITE],
        'inLanguage'  => 'en-US',
    ]);
    $log[] = '✓ /blog → Blog';

    add_schema('/blog', 'BreadcrumbList', bc([
        ['Home', SITE.'/'], ['Blog', SITE.'/blog']
    ]));
    $log[] = '✓ /blog → BreadcrumbList';

    $total = count($log);
}

// ── UI ───────────────────────────────────────────────────────────
?><!doctype html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Schema Seeder — Homecare Creators Admin</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:#fff;border-radius:16px;padding:36px 40px;max-width:740px;width:100%}
h1{font-size:22px;font-weight:800;color:#0a2e1e;margin-bottom:8px}
p{font-size:14px;color:#6b7280;margin-bottom:16px;line-height:1.75}
strong{color:#0a2e1e}
.log{background:#f3f4f6;border-radius:10px;padding:16px 20px;max-height:420px;overflow-y:auto;font-size:12px;font-family:monospace;line-height:2}
.log div{color:#1a5c3a}
.btn{display:inline-block;padding:13px 28px;background:#1d9e75;color:#fff;border-radius:9px;text-decoration:none;font-weight:700;font-size:15px;margin-top:16px;margin-right:8px}
.btn-outline{background:#fff;color:#1d9e75;border:2px solid #1d9e75}
.warn{background:#fff1f2;border:2px solid #fca5a5;border-radius:10px;padding:14px 18px;margin-top:20px;color:#7f1d1d;font-size:13px;line-height:1.9}
.count{font-size:34px;font-weight:900;color:#1d9e75;display:block;margin-bottom:4px}
code{background:#f3f4f6;padding:2px 7px;border-radius:4px;font-size:11.5px;word-break:break-all}
ul{margin:12px 0 12px 20px;font-size:13px;color:#374151;line-height:1.9}
</style></head><body>
<div class="card">
<h1>Schema Seeder</h1>
<?php if (!$run): ?>
<p>This will <strong>TRUNCATE hc_page_schema</strong> and insert comprehensive, deeply researched schema blocks for every public page. Schema types included:</p>
<ul>
  <li><strong>Homepage</strong> — MarketingAgency, WebSite, FAQPage (10 Qs)</li>
  <li><strong>Website Design service page</strong> — Service, FAQPage (6 Qs), BreadcrumbList</li>
  <li><strong>10 marketing city pages</strong> — LocalBusiness, Service, FAQPage (5 Qs), BreadcrumbList each</li>
  <li><strong>6 web-design city pages</strong> — Service, FAQPage (4 Qs), BreadcrumbList each</li>
  <li><strong>About page</strong> — AboutPage + Person (founder), BreadcrumbList</li>
  <li><strong>Contact page</strong> — ContactPage, BreadcrumbList</li>
  <li><strong>AI Search SEO page</strong> — Service, FAQPage (7 Qs), BreadcrumbList</li>
  <li><strong>Areas We Serve hub</strong> — CollectionPage, FAQPage (4 Qs), BreadcrumbList</li>
  <li><strong>CareOS page</strong> — SoftwareApplication, BreadcrumbList</li>
  <li><strong>5 adjacent-vertical pages</strong> (memory care, hospice, nursing homes, senior living, assisted living) — Service, FAQPage (6 Qs each), BreadcrumbList each</li>
  <li><strong>Blog index</strong> — Blog, BreadcrumbList</li>
</ul>
<p><strong>~100 schema blocks total.</strong> All page paths match the actual $page_canonical values from each page file. Safe to re-run — TRUNCATEs first.</p>
<a href="?run=1" class="btn">&#9654; Run Schema Seeder</a>
<a href="/admin/schema/" class="btn btn-outline">View Schema Manager</a>

<?php else: ?>
<span class="count"><?= $total ?></span>
<p><strong><?= $total ?> schema blocks</strong> inserted successfully across all pages.</p>
<div class="log">
  <?php foreach ($log as $l): ?><div><?= htmlspecialchars($l) ?></div><?php endforeach ?>
</div>
<div class="warn">
  <strong>Security: delete this file immediately after running.</strong> SSH command:<br><br>
  <code>rm /home/homecarecreators/htdocs/homecarecreators.com/admin/seed-schema.php</code><br><br>
  Or delete via FTP: <code>admin/seed-schema.php</code>
</div>
<a href="/admin/schema/" class="btn" style="margin-top:20px">View Schema Manager &#8594;</a>
<?php endif ?>
</div>
</body></html>
