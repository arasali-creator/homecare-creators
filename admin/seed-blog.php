<?php
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/auth.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
hc_require_auth();

if (($_GET['run'] ?? '') !== '1') {
    echo '<p>Add <strong>?run=1</strong> to the URL to seed blog posts.</p>';
    exit;
}

// ── BLOG POST 1 ───────────────────────────────────────────────────────────────
$post1_content = <<<'HTML'
<h2 id="the-visibility-problem">The Google Visibility Problem Most Home Care Agencies Don't Know They Have</h2>
<p>Here's a scenario that plays out every day in Florida: a family in Tampa is desperately searching "home care agency near me" at 11pm because their mother just got discharged from the hospital and needs help. They scroll through the first few results, call two agencies, and book a consultation with one of them.</p>
<p>Your agency might be better. Your caregivers might be more experienced. Your rates might be more competitive. But if you're not on page one — ideally in the top three of the Google Maps pack — that family will never know you exist.</p>
<p>This is the quiet crisis facing the majority of home care agencies in Florida right now. Not a lack of quality. Not a lack of staff. A lack of visibility.</p>
<p>The good news: Google visibility is a fixable problem. And unlike paid ads that stop working the moment you stop paying, SEO compounds over time — meaning the work you do today pays dividends for years. Here's exactly why you're not showing up, and what to do about it.</p>

<h2 id="reason-1-google-business-profile">Reason #1: Your Google Business Profile Is Incomplete or Unverified</h2>
<p>Google Business Profile (formerly Google My Business) is the single most important asset for local home care agency visibility. When someone searches "home care agency in [your city]," the Map Pack — those three business listings with stars and a phone number that appear before the organic results — is what families click on first.</p>
<p>Most agencies have claimed their listing but haven't optimized it. A complete, optimized GBP includes:</p>
<ul>
  <li><strong>100% complete profile</strong> — business name, address, phone, website, hours, and service areas all filled in</li>
  <li><strong>Primary category set to "Home Health Care Service"</strong> with secondary categories like "Aged Care" or "Nursing Agency" added</li>
  <li><strong>A keyword-rich business description</strong> that mentions your city, your services, and what makes you different — naturally written, not stuffed</li>
  <li><strong>20+ photos uploaded</strong> — your office, your team, events, client moments (with permission) — listings with photos get 35% more click-throughs</li>
  <li><strong>Services listed individually</strong> — companionship care, personal care, Alzheimer's care, 24/7 live-in care listed as separate services with descriptions</li>
  <li><strong>Weekly Google posts</strong> — short updates, promotions, or tips that signal to Google your business is active</li>
  <li><strong>Q&A section monitored and answered</strong> — Google lets anyone ask questions on your profile; if you don't answer them, random people will</li>
</ul>
<blockquote>Agencies with fully optimized GBPs are 70% more likely to attract in-person visits and 50% more likely to lead to a purchase according to Google's own research.</blockquote>
<p>If your profile has fewer than 10 photos, a generic description, and no regular posts, this is almost certainly contributing to your visibility problem.</p>

<h2 id="reason-2-no-local-seo-foundation">Reason #2: Your Website Has No Local SEO Foundation</h2>
<p>Your website is your most important digital asset — but only if it's built to be found. Most home care agency websites are essentially digital brochures: they look nice, explain services, and sit there doing nothing for SEO.</p>
<p>A website with a local SEO foundation does things differently:</p>
<ul>
  <li><strong>Dedicated city service pages</strong> — if you serve Miami, Tampa, Fort Lauderdale, and Boca Raton, you need a separate page optimized for each city. "Home care agency in Miami" and "home care agency in Tampa" are entirely different searches. One generic page can't rank for both.</li>
  <li><strong>Location-optimized title tags and meta descriptions</strong> — your title tag should include your primary service and city: "Home Care Agency in Miami, FL | [Agency Name]"</li>
  <li><strong>Schema markup (structured data)</strong> — this is code added to your pages that tells Google exactly what your business is, where it operates, what services it provides, and what people say about it. It directly improves your chances of appearing in rich results.</li>
  <li><strong>Your NAP (name, address, phone) in text on every page footer</strong> — not in an image, not embedded in a map — actual crawlable text</li>
  <li><strong>Internal links connecting your service pages</strong> — Google needs to understand the structure of your site to rank it effectively</li>
</ul>
<p>Without these elements, you're essentially handing your competitors free ranking positions while you wait for clients who never call.</p>

<h2 id="reason-3-zero-reviews">Reason #3: You Have Zero Online Reviews (Or Mostly Negative Ones)</h2>
<p>Google Reviews are one of the top three ranking factors for the local Map Pack. Not just the number of reviews — the recency, the response rate, and the content of those reviews all matter.</p>
<p>An agency with 47 reviews averaging 4.8 stars will almost always outrank an agency with 8 reviews averaging 4.2 stars, all else being equal. And when families are making a sensitive, high-trust decision about care for a loved one, they read reviews carefully.</p>
<p>The biggest mistake agencies make: they wait for reviews to happen organically. They don't. You have to systematically ask for them. The best time to ask: right after a successful caregiver placement, when the family is experiencing relief and gratitude.</p>
<p>A simple script: <em>"Mrs. Johnson, we're so glad Maria has been a good fit for your mother. We rely on feedback from families like yours to help other people find us when they need help. Would you be willing to leave us a quick Google review? I can text you the direct link right now."</em></p>
<p>That one sentence, used consistently, can transform your Google visibility within 90 days.</p>

<h2 id="reason-4-slow-on-mobile">Reason #4: Your Website Loads Slowly on Mobile</h2>
<p>Over 70% of healthcare searches now happen on mobile devices. Google has used mobile-first indexing since 2019, meaning it evaluates the mobile version of your site — not the desktop version — when deciding where to rank you.</p>
<p>If your site takes more than 3 seconds to load on a phone, you're being penalized in the rankings and losing visitors who bounce before the page loads. Both hurt you.</p>
<p>Test your site right now at <strong>PageSpeed Insights</strong> (search for it in Google). If you score below 60 on mobile, your site speed is actively suppressing your rankings. Common culprits: uncompressed images, too many plugins, cheap shared hosting, and outdated WordPress themes.</p>

<h2 id="reason-5-no-local-citations">Reason #5: Your Competitors Have More Local Citations Than You</h2>
<p>A local citation is any online mention of your business name, address, and phone number — on directories like Yelp, Healthgrades, Care.com, Senior Advisor, Home Care Pulse, the Better Business Bureau, and dozens of others.</p>
<p>Google uses citation consistency and volume as a trust signal. An agency listed on 40 authoritative directories with consistent NAP information is seen as more legitimate than an agency that only appears on Google itself.</p>
<p>More importantly: many families search specifically on Care.com or Senior Advisor before going to Google. If you're not listed there, you're invisible to an entire segment of your market.</p>

<h2 id="90-day-fix">The 90-Day Fix: What to Do Starting Today</h2>
<p>You don't have to fix everything at once. Here's a prioritized 90-day roadmap:</p>
<ul>
  <li><strong>Days 1–7:</strong> Fully optimize your Google Business Profile. Add photos, update your description with local keywords, list all services, and set up weekly posting.</li>
  <li><strong>Days 8–30:</strong> Implement a review request system. Identify 10 current or recent families and ask for Google reviews personally. Aim for 2–3 new reviews per week going forward.</li>
  <li><strong>Days 31–60:</strong> Audit your website for local SEO basics — title tags, meta descriptions, city pages, and schema markup. Fix the biggest gaps first.</li>
  <li><strong>Days 61–90:</strong> Build citations on the top 20 healthcare directories. Ensure your NAP is identical across every listing.</li>
</ul>
<p>By day 90, most agencies that follow this framework see measurable improvement in their Google Maps rankings and a noticeable increase in inbound calls from organic search.</p>

<h2 id="why-diy-makes-things-worse">Why DIY SEO Usually Makes Things Worse</h2>
<p>The steps above sound simple. And the concepts are simple. But the execution — technical auditing, keyword research, on-page optimization, citation building, schema markup, content strategy — is where most agency owners run out of time or make mistakes that create new problems.</p>
<p>We've worked with agencies that tried to fix their own SEO and accidentally created duplicate listings, keyword-stuffed their GBP description (which got them suspended), or built dozens of citations with inconsistent NAP data — all of which actively hurt their rankings.</p>
<p>Home care is your expertise. Local SEO is ours. At <strong>Homecare Creators</strong>, we specialize exclusively in marketing home care agencies in Florida — which means we know exactly which keywords your ideal clients are using, which directories matter most in your market, and how to build a system that keeps generating clients month after month.</p>
<p>If you're ready to stop being invisible and start showing up where families are searching, <a href="/local-seo-for-home-care-agencies/">explore our home care SEO packages</a> or request a free audit below — we'll show you exactly where you stand versus your competitors.</p>
HTML;

// ── BLOG POST 2 ───────────────────────────────────────────────────────────────
$post2_content = <<<'HTML'
<h2 id="why-private-pay-matters">Why Private-Pay Clients Are the Key to a Profitable Home Care Agency</h2>
<p>If you've been running a home care agency for more than a year, you already know the math: Medicaid reimbursement rates rarely cover your true cost of care. You're paying $14–$18/hour for a caregiver, billing Medicaid $15–$19, and trying to build a sustainable business on margins that leave almost nothing for growth, marketing, or your own salary.</p>
<p>Private-pay clients change that equation completely. At $25–$35/hour (or higher for specialized care), a single private-pay family generating 40 hours/week is worth $52,000–$72,800/year in revenue — at margins that actually allow you to run a real business.</p>
<p>The agencies that are growing fast in Florida right now have all figured out the same thing: you don't compete on price with Medicaid. You build a premium brand that attracts families who are willing to pay for quality, and you use digital marketing — specifically local SEO — to put that brand in front of them at exactly the moment they're searching.</p>
<p>Here's the exact formula those agencies are using.</p>

<h2 id="how-private-pay-families-search">How Private-Pay Families Actually Find Home Care Agencies Online</h2>
<p>Understanding the private-pay family's search journey is the foundation of your entire marketing strategy. It looks like this:</p>
<p><strong>Stage 1 — Crisis trigger:</strong> A parent falls, gets a hospital diagnosis, or can no longer live alone. The adult child (typically a daughter, 45–65 years old) opens Google on her phone.</p>
<p><strong>Stage 2 — Initial search:</strong> She types "home care agency in [her city]" or "in-home care for elderly parents [city]" or "caregiver for dementia mom [city]." She looks at the Map Pack and clicks the top 2–3 listings.</p>
<p><strong>Stage 3 — Website evaluation:</strong> She spends 30–90 seconds on each website. If the site doesn't immediately communicate trust, professionalism, and the specific type of care her parent needs, she hits back and moves to the next result.</p>
<p><strong>Stage 4 — Review validation:</strong> Before calling, she reads Google reviews. She's looking for recent reviews from families in situations similar to hers. She wants to know: did this agency show up? Were the caregivers kind? Did the family feel supported?</p>
<p><strong>Stage 5 — First call:</strong> She calls. The way that call is handled determines whether she books a consultation.</p>
<p>Your entire job as a marketing-savvy agency owner is to appear prominently at Stage 2, earn her trust at Stage 3, validate it at Stage 4, and convert at Stage 5. Most agencies only work on Stage 5. That's why they're struggling.</p>

<h2 id="step-1-get-found">Step 1: Get Found When Private-Pay Families Are Searching</h2>
<p>The most valuable real estate on the internet for your agency is the Google Maps Pack — those three business listings that appear at the top of local search results. Families in crisis don't scroll past page one. They click one of those three listings.</p>
<p>To rank there, you need:</p>
<ul>
  <li>A fully optimized Google Business Profile with complete service listings, 20+ photos, and consistent weekly activity</li>
  <li>A website with dedicated pages for each city you serve — not one generic "service areas" page</li>
  <li>A strong review profile (minimum 25 reviews, 4.5+ average) that demonstrates social proof at scale</li>
  <li>Consistent NAP (name, address, phone) data across all online directories</li>
</ul>
<p>Private-pay families are specifically searching with higher-value keywords. Phrases like "private duty home care [city]," "licensed home care agency [city]," and "Alzheimer's care at home [city]" signal high intent and typically have lower competition than generic searches — meaning they're actually easier to rank for if you've done your SEO correctly.</p>

<h2 id="step-2-build-a-trustworthy-website">Step 2: Build a Website That Families Trust in Under 30 Seconds</h2>
<p>Private-pay clients are making a high-stakes, emotionally charged decision. They're entrusting a stranger with the care of someone they love. Your website needs to communicate trust within the first 30 seconds — or they're gone.</p>
<p>What trust looks like on a home care website:</p>
<ul>
  <li><strong>Real photos of real people</strong> — your face as the owner, your care team, your office. Stock photos of smiling seniors immediately signal "generic agency." Real photos say "this is a real business run by real people who care."</li>
  <li><strong>Your story, prominently placed</strong> — why did you start this agency? What's your personal connection to home care? Families connect with mission-driven owners, not corporations.</li>
  <li><strong>Licensing and accreditation badges visible above the fold</strong> — AHCA license number, any CHAP or Joint Commission accreditation, BBB rating. These reduce anxiety instantly.</li>
  <li><strong>A clear, specific value proposition</strong> — not "compassionate care for your loved ones" (every agency says that). Something specific: "Alzheimer's-specialized care with a dedicated family liaison — so you never have to wonder how your parent is doing."</li>
  <li><strong>Specific service descriptions</strong> — private-pay families are often looking for specific types of care: dementia care, post-surgery recovery, 24/7 live-in care. If you specialize in any of these, say so loudly on your homepage.</li>
</ul>

<h2 id="step-3-convert-searchers">Step 3: Convert Searchers Into Consultation Calls</h2>
<p>A family lands on your website in a moment of stress. Your job is to make it as easy as possible for them to take the next step. Most agencies bury their contact information, have a generic "contact us" form that nobody fills out, and no clear next step.</p>
<p>What converts:</p>
<ul>
  <li>A phone number in large text in the top right corner of every page — clickable on mobile</li>
  <li>A "Schedule a Free Consultation" button (not "Contact Us") that opens a simple calendar booking or a short form</li>
  <li>Live chat during business hours — families searching at 9pm won't wait until morning to get an answer from a competitor</li>
  <li>A clear explanation of what happens next: "We'll call within 2 hours to schedule a free in-home assessment"</li>
</ul>
<blockquote>"Schedule a Free In-Home Assessment" converts at 3–4x the rate of "Contact Us" for home care agencies, because it sets a clear, low-risk expectation.</blockquote>

<h2 id="step-4-reviews-that-build-trust">Step 4: Collect and Display Reviews That Build Trust</h2>
<p>For private-pay clients specifically, reviews are not optional — they're load-bearing. A family spending $5,000–$8,000/month on care will read every review you have.</p>
<p>The most powerful reviews for private-pay clients mention: specific caregivers by name, the type of condition the family was dealing with (dementia, cancer, post-surgery), how the agency handled a difficult situation, and the emotional outcome — "our family finally felt like we could breathe again."</p>
<p>Ask for reviews systematically. Create a direct review link from your Google Business Profile and text it to satisfied families immediately after a positive interaction. Make it three taps: open text, click link, tap stars, type two sentences. That's all it takes.</p>
<p>Display your best reviews on your website — not just a Google widget, but curated testimonials with the family's first name, their parent's situation, and their outcome. Real stories convert better than star ratings alone.</p>

<h2 id="step-5-location-content">Step 5: Use Location-Based Content to Capture Local Intent</h2>
<p>Private-pay families are local. They're searching for agencies in their specific city, often in specific neighborhoods. A content strategy that targets these local searches puts you in front of exactly the right people.</p>
<p>This means creating dedicated pages for every city and major suburb you serve — not just a "service areas" dropdown menu. Each page should explain: your services in that specific city, why families in that area choose you, any local facilities you work with (hospitals, rehab centers, assisted living), and client stories from that community.</p>
<p>It also means creating blog content that answers the exact questions private-pay families are asking: "How much does in-home care cost in Miami?", "What's the difference between home health care and private duty care?", "How do I know when my parent needs full-time care?"</p>
<p>When you answer these questions better than anyone else in your market, Google sends you the traffic. And that traffic — families actively researching care options — converts at a far higher rate than anyone who sees an ad.</p>

<h2 id="seo-beats-ads">The Compound Effect: Why SEO Beats Paid Ads for Home Care</h2>
<p>Many agencies try Google Ads before SEO because it feels faster. And it is faster — you can have ads running in 24 hours. But here's the math that changes minds:</p>
<p>A Google Ad campaign generating 10 leads/month might cost $2,000–$4,000/month in ad spend, plus management fees. Stop paying, and your leads stop immediately. On paid ads, you're renting visibility.</p>
<p>An SEO investment that takes 6–9 months to reach page one, once there, generates those same 10 leads/month for the cost of ongoing maintenance — typically 70–80% less than paid ads over 24 months. And unlike ads, your rankings don't disappear when you stop writing checks. You own that visibility.</p>
<p>The agencies that are winning the private-pay market in Florida invested in SEO 12–24 months ago. They're now reaping the compound returns. The agencies just starting their SEO journey today will be in that same position in 12–24 months — but only if they start now.</p>
<p>At <a href="/local-seo-for-home-care-agencies/">Homecare Creators</a>, we work exclusively with home care agencies in Florida. We know which keywords private-pay families in Miami, Tampa, Orlando, and beyond are using to find agencies like yours — and we build the system that puts you in front of them. Request a free audit below to see where you stand today.</p>
HTML;

// ── BLOG POST 3 ───────────────────────────────────────────────────────────────
$post3_content = <<<'HTML'
<h2 id="why-home-care-websites-fail">Why Most Home Care Websites Fail to Convert Families</h2>
<p>Most home care agency websites were built to check a box. The owner needed "a website," hired someone on Fiverr or used a template, uploaded some stock photos of seniors holding hands, listed their services, put their phone number somewhere, and called it done.</p>
<p>That website isn't hurting you. But it's not helping you either. In a market where families are making a high-emotion, high-stakes decision about the care of someone they love, a mediocre website is the equivalent of showing up to a first meeting in a wrinkled shirt — technically acceptable, but not what wins the business.</p>
<p>A home care website that actually converts families into clients is a fundamentally different type of asset. It's built around the family's psychology — their fears, their questions, their decision criteria — and it guides them from "I need help" to "I'm calling this agency" in under 60 seconds.</p>
<p>Here are the 11 elements that separate a home care website that generates leads from one that just sits there.</p>

<h2 id="clear-value-proposition">1. A Crystal-Clear Value Proposition Above the Fold</h2>
<p>"Above the fold" means what a visitor sees before they scroll. On a home care website, this is the most valuable real estate you have — and most agencies waste it on generic headlines like "Compassionate Care for Your Loved Ones" that say nothing and differentiate you from nobody.</p>
<p>Your value proposition above the fold should answer three questions in under 10 words: <em>What do you do? Who do you do it for? Why should I choose you?</em></p>
<p>Examples that work:</p>
<ul>
  <li>"Licensed Home Care for Seniors in Miami — Background-Checked Caregivers, 24/7 Support"</li>
  <li>"Dementia-Specialized In-Home Care in Tampa | Your Loved One Stays Home, Safely"</li>
  <li>"Private Duty Home Care in Boca Raton — 100+ Five-Star Families Trust Us"</li>
</ul>
<p>Notice what these have in common: they're specific, local, and they address the family's core fear (is my parent safe? can I trust this agency?).</p>

<h2 id="mobile-speed">2. Mobile-First Design That Loads in Under 3 Seconds</h2>
<p>More than 70% of home care searches happen on mobile devices. A website that's slow or awkward on a phone is leaking leads constantly — and you'll never know, because visitors just leave.</p>
<p>Your site should load in under 3 seconds on a 4G connection. Test it at Google's PageSpeed Insights. If you score below 60 on mobile, you have a problem that's actively suppressing your Google rankings and costing you leads. Common fixes: compress images, eliminate unnecessary plugins, upgrade your hosting, use a modern PHP stack instead of a bloated WordPress theme.</p>

<h2 id="clear-ctas">3. Obvious, Repeated Calls-to-Action</h2>
<p>Families in crisis don't browse websites the way they browse Amazon. They're looking for one thing: how do I get help? Make the answer impossible to miss.</p>
<p>Your CTA should appear: in the hero section, after your services description, after your testimonials, and in the footer. The button text should be action-oriented and specific: "Schedule a Free Home Assessment" or "Call Us Now — We Answer 24/7" — not the generic "Learn More" or "Contact Us" that every other website uses.</p>
<p>Your phone number should be in large, bold text in the top right corner on desktop, and clickable-to-call on mobile. Families in crisis don't want to fill out a form. They want to talk to a human. Make calling as frictionless as possible.</p>

<h2 id="real-photos">4. Real Staff Photos and Owner Story</h2>
<p>Stock photos of smiling seniors and diverse caregivers have become so ubiquitous on home care websites that they're now invisible — worse, they signal "generic agency." Families have seen them a thousand times and they register nothing.</p>
<p>Real photos of your actual owner, your actual care team, and your actual office convert dramatically better. They humanize your brand. They say: "There are real people here who will answer when you call and show up when your parent needs them."</p>
<p>Your owner's story — why you started the agency, your personal connection to home care, what you believe about quality care — should be on your homepage and your About page. Families choose agencies whose owners they feel like they know and trust. Give them the chance to know you.</p>

<h2 id="testimonials">5. Star Ratings and Authentic Testimonials Front and Center</h2>
<p>Social proof is the most powerful trust-building tool you have. A family who has never met you will believe other families who have. Place your best testimonials prominently — not buried on a "Reviews" page that nobody clicks.</p>
<p>What makes a testimonial convert: specific details ("After Mom's stroke, we didn't know what to do — Maria was there every morning within a week"), specific outcomes ("Dad actually looks forward to seeing his caregiver now"), and the reviewer's first name and relationship ("Jennifer T., Daughter of Client"). Generic testimonials like "Great service! Highly recommend!" add almost no conversion value.</p>
<p>Embed your Google Review widget with your live star rating on your homepage. Live ratings feel authentic in a way that curated testimonials don't.</p>

<h2 id="service-pages">6. Services Pages That Are Actually About the Client's Problem</h2>
<p>Most home care service pages read like a brochure: "We offer personal care, companionship, medication reminders, light housekeeping…" followed by a list of bullet points. This does not convert families.</p>
<p>A service page that converts is written around the family's specific fear and situation. Instead of "Alzheimer's and Dementia Care," write "Your Parent Has Dementia — Here's How We Help Your Family." Instead of "Personal Care," write "When Your Parent Needs Help With the Basics, We Handle It With Dignity."</p>
<p>Each service should have its own dedicated page, not a section on a single long page. Dedicated pages rank better on Google and give you room to fully address the family's concerns for that specific type of care.</p>

<h2 id="local-seo-architecture">7. A Local SEO Architecture That Matches How Families Search</h2>
<p>This is the element most agencies never build — and it's one of the highest-ROI things you can do. Families search locally: "home care agency Miami," "in-home care Tampa," "dementia care Boca Raton." If you serve multiple cities, you need a dedicated page for each one.</p>
<p>Each city page should include: the city name in the title, the H1, and the first paragraph; local details like neighborhoods you cover, local hospitals you work with, and community resources for seniors in that area; and testimonials from families in that city if possible.</p>
<p>This architecture is why some agencies appear in searches across 10 different Florida cities while their competitors only appear in their immediate neighborhood. It's not magic — it's deliberate page structure.</p>

<h2 id="trust-badges">8. Trust Badges, Licenses, and Accreditations</h2>
<p>Display your AHCA license number. If you're accredited by CHAP, Joint Commission, or ACHC — display that badge prominently. If you're a member of the Home Care Association of Florida — display it. If you have an A+ BBB rating — display it.</p>
<p>These signals reduce anxiety for families who are worried about hiring a licensed, reputable agency. They're especially important above the fold and near your CTA buttons, where the family is deciding whether to call.</p>

<h2 id="live-chat">9. Live Chat or "Call Us Now" Prominently Placed</h2>
<p>A significant portion of home care searches happen outside business hours — evenings and weekends, when families have time to research. If your site has no way for them to get an immediate response at 9pm on a Sunday, you're losing leads to competitors who do.</p>
<p>A simple chat widget connected to your phone (many free options exist) lets you capture after-hours leads. Even an automated "Leave your number and we'll call first thing in the morning" workflow is better than nothing. The family who feels like someone responded to them at 9pm will answer your 9am call.</p>

<h2 id="blog-content">10. A Blog That Answers Real Family Questions</h2>
<p>Families research home care for weeks before making a decision. During that research phase, they're typing questions into Google: "How do I know when my parent needs in-home care?", "What's the difference between home health and private duty?", "How much does 24-hour care cost in Florida?"</p>
<p>If your blog answers those questions — thoughtfully, specifically, and helpfully — you earn their trust before they've even visited your homepage. And when they're ready to make a decision, you're the agency they already feel like they know.</p>
<p>A blog with 20 well-written, genuinely helpful posts targeting the questions your ideal clients are asking will generate more qualified leads than any Google Ad campaign you could run — and the cost is your time, not ongoing ad spend.</p>

<h2 id="schema-markup">11. Schema Markup for Rich Search Results</h2>
<p>Schema markup is code added to your website that tells Google precisely what your business is, where it operates, what it offers, and what people say about it. When done correctly, it can earn your site rich results in search — star ratings displayed directly in the search results, FAQ dropdowns, and enhanced local business information.</p>
<p>Most home care agencies don't have schema markup at all. The ones that do have a measurable advantage in click-through rates from search — which means more traffic from the same ranking position.</p>

<h2 id="roi-of-good-website">The ROI of Getting Your Website Right</h2>
<p>A home care website that converts is not an expense — it's the highest-return asset in your marketing portfolio. Consider: if your average client is worth $3,500/month and stays with you for 18 months, a single converted lead is worth $63,000 in lifetime revenue. If a better website converts even 2 additional families per month, that's $126,000 in additional monthly pipeline.</p>
<p>At <a href="/homecare-website-design/">Homecare Creators</a>, we design websites built exclusively for home care agencies — with all 11 of these elements built in from day one, plus local SEO architecture that helps you rank in every city you serve. If your current website isn't generating consistent inquiries, it's costing you clients every day it stays the way it is.</p>
HTML;

// ── BLOG POST 4 ───────────────────────────────────────────────────────────────
$post4_content = <<<'HTML'
<h2 id="why-local-seo-matters">Why Local SEO Is the Single Best Marketing Investment for Home Care Agencies</h2>
<p>Every home care client you'll ever have is local. They live within 10–20 miles of your office. Their family is driving distance from your caregivers. Every single lead you need comes from your immediate geographic market.</p>
<p>This is why local SEO — the practice of optimizing your online presence to appear in local searches — is not just one marketing option among many for home care agencies. It's the marketing channel with the highest ROI, the longest-lasting returns, and the most direct connection to how families actually find care.</p>
<p>When a daughter in Tampa types "home care agency near me" into Google at 10pm, she's going to call one of the three agencies in the Map Pack. This guide will show you exactly how to be one of those three.</p>

<h2 id="google-business-profile">Step 1: Claim and Fully Optimize Your Google Business Profile</h2>
<p>Your Google Business Profile (GBP) is the foundation of your local SEO. It's what creates your Map Pack listing — the single most valuable placement in all of local search. Here's how to optimize it completely:</p>
<p><strong>Name:</strong> Use your exact legal business name. Don't add keywords ("Best Home Care Agency Miami") — Google will suspend listings that keyword-stuff the business name.</p>
<p><strong>Category:</strong> Set your primary category to "Home Health Care Service." Add secondary categories: "Aged Care Service," "Nursing Agency," "Disability Services and Support Organization" — whichever apply to your business.</p>
<p><strong>Address and Phone:</strong> Use your exact address and a local phone number (not a toll-free number). Consistency here is critical — this exact address and phone must match everywhere else on the internet.</p>
<p><strong>Service Areas:</strong> List every city, county, and major neighborhood you serve. The more specific, the better. If you serve both Miami-Dade and Broward County, list both, plus Fort Lauderdale, Coral Springs, Pembroke Pines, etc.</p>
<p><strong>Business Description:</strong> Write a 250-word description that naturally includes your primary services and cities. Avoid keyword stuffing — write for the family reading it, not the algorithm. Include your unique differentiator.</p>
<p><strong>Photos:</strong> Upload a minimum of 25 photos. Include: your exterior and interior, your team members, client events (with permission), your owner's headshot, your vehicles if you have branded ones, and any certifications or awards displayed in your office. Listings with photos get 35% more website clicks.</p>
<p><strong>Services:</strong> Add every service you offer as a separate service in GBP — personal care, companion care, dementia care, medication management, 24-hour care, etc. Each service can have its own description.</p>
<p><strong>Posts:</strong> Publish a Google Post every week. Share a caregiving tip, a family testimonial, a seasonal health article, or a service spotlight. This signals to Google that your listing is active and maintained.</p>

<h2 id="nap-consistency">Step 2: Build NAP Consistency Across the Web</h2>
<p>NAP stands for Name, Address, Phone Number. Google uses the consistency of your NAP information across the entire internet as a trust signal. If your business is listed as "ABC Home Care LLC" on Google, "ABC Home Care" on Yelp, and "ABC Homecare" on Senior Advisor — these inconsistencies signal unreliability.</p>
<p>Audit every directory where your business is listed and ensure your NAP is identical everywhere. This includes:</p>
<ul>
  <li>Your website (footer and contact page)</li>
  <li>Google Business Profile</li>
  <li>Yelp, Facebook, Apple Maps</li>
  <li>Senior-specific: SeniorAdvisor.com, Care.com, Caring.com, A Place for Mom, HomeAdvisor</li>
  <li>Healthcare: Healthgrades, Zocdoc (if applicable)</li>
  <li>General: BBB, Yellow Pages, Angi, Thumbtack</li>
  <li>State-specific: Florida AHCA provider directory</li>
</ul>
<p>Use the exact same formatting everywhere: same suite number format (#200 vs Suite 200), same phone number format, same abbreviations. The more consistent your NAP, the more Google trusts that your business is legitimate and well-established.</p>

<h2 id="google-reviews">Step 3: Get More Google Reviews (The Right Way)</h2>
<p>Google Reviews are one of the top three ranking factors for the local Map Pack. Volume matters. Recency matters. Rating matters. Response rate matters. Here's how to build a review system that works:</p>
<p><strong>Create a direct review link:</strong> In your Google Business Profile dashboard, find the "Get more reviews" button and copy your direct review link. This takes families directly to the review form — no hunting required.</p>
<p><strong>Ask at the right moment:</strong> The best time to ask for a review is immediately after a positive emotional moment — the first week of care when the family expresses relief, after a successful hospital-to-home transition, or when a client says something like "Maria is so wonderful."</p>
<p><strong>Make it easy:</strong> Text the review link directly to the family contact's phone. A simple message: "Hi [Name], we're so glad [caregiver] has been a great fit for [client]. If you have 2 minutes, a Google review helps other families find us when they need help: [link]. Thank you!"</p>
<p><strong>Respond to every review:</strong> Google tracks your response rate. Thank positive reviewers by name and reference something specific from their review. For negative reviews, respond professionally and move the conversation offline — never argue publicly.</p>
<p><strong>Goal:</strong> Aim for 4–5 new reviews per month minimum. An agency with 60+ reviews averaging 4.7 stars will almost always rank above an agency with 12 reviews averaging 4.9 stars.</p>
<blockquote>93% of families say online reviews impact their decision when choosing a home care provider — and families read an average of 7 reviews before contacting an agency.</blockquote>

<h2 id="location-service-pages">Step 4: Create Location-Specific Service Pages on Your Website</h2>
<p>Your Google Business Profile handles your Map Pack presence. Your website handles your organic ranking presence. And for organic rankings in multiple cities, you need dedicated pages for each location you serve.</p>
<p>If you serve Miami, Tampa, and Fort Lauderdale, you need three separate pages:</p>
<ul>
  <li><strong>/home-care-miami-fl/</strong> — targeting "home care agency Miami FL"</li>
  <li><strong>/home-care-tampa-fl/</strong> — targeting "home care agency Tampa FL"</li>
  <li><strong>/home-care-fort-lauderdale-fl/</strong> — targeting "home care agency Fort Lauderdale FL"</li>
</ul>
<p>Each page needs: the city name in the title tag, H1, first paragraph, and naturally throughout the content. Include local details — nearby hospitals, senior centers, or neighborhoods you serve in that city. Add a Google Map embed with your address. Include city-specific testimonials if you have them.</p>
<p>These pages are the reason some agencies appear in searches across 15 Florida cities while their competitors only rank in their immediate zip code. It's one of the highest-leverage investments in local SEO.</p>

<h2 id="local-citations">Step 5: Build Local Citations on Healthcare Directories</h2>
<p>Beyond the major platforms, the home care industry has a set of niche directories that carry significant weight with both Google and families researching agencies. Being listed on these platforms:</p>
<ul>
  <li>Signals to Google that you're a legitimate, established provider in your space</li>
  <li>Puts you in front of families who search on those platforms directly</li>
  <li>Builds backlinks to your website that improve your overall domain authority</li>
</ul>
<p>Priority healthcare directory citations: SeniorAdvisor.com, Caring.com, Care.com, A Place for Mom (if applicable), Assisted Living Directory, Home Care Pulse directory, HCAOA member directory (if applicable), and your state's AHCA provider lookup.</p>
<p>Create complete, detailed profiles on each platform — not just your NAP, but services, hours, a full description, photos, and a link to your website. Incomplete directory profiles have minimal value.</p>

<h2 id="local-backlinks">Step 6: Earn Local Backlinks That Signal Authority</h2>
<p>A backlink is when another website links to yours. Google treats backlinks from authoritative, relevant websites as votes of confidence. Local backlinks — from other Florida businesses, organizations, and publications — specifically boost your local rankings.</p>
<p>The best local backlinks for home care agencies come from:</p>
<ul>
  <li><strong>Local hospitals and discharge planners</strong> — if you have a referral relationship with a hospital, ask if they'll list you on their "community resources" or "post-discharge care" page</li>
  <li><strong>Area Agency on Aging (AAA)</strong> — Florida's AAA chapters maintain resource directories for seniors; get listed</li>
  <li><strong>Senior centers and community organizations</strong> — sponsor an event, volunteer, or contribute an educational resource in exchange for a link</li>
  <li><strong>Local chambers of commerce</strong> — member directory listings usually include a link to your website</li>
  <li><strong>Local news publications</strong> — if you do something newsworthy (community event, caregiver recognition, expansion), local news sites may cover it and link to you</li>
</ul>

<h2 id="how-long-does-seo-take">How Long Does Local SEO Take to Work?</h2>
<p>This is the question every agency owner asks, and the honest answer requires nuance. If your market has limited competition and you're starting with a basic-but-functional website, you may see meaningful movement in Google Maps rankings within 60–90 days of consistent work.</p>
<p>In more competitive markets — Miami, Tampa, Orlando — where you're competing against agencies that have been investing in SEO for years, it typically takes 6–12 months of consistent work to reach page one for competitive keywords.</p>
<p>What makes the difference: the quality and consistency of your implementation, the authority of your website and GBP before you start, and how aggressively your competitors are investing in their own SEO.</p>

<h2 id="results-after-90-days">What Results Look Like After 90 Days of Proper Local SEO</h2>
<p>Based on the agencies we've worked with at Homecare Creators across Florida, here's what a typical 90-day trajectory looks like for an agency starting from a modest online presence:</p>
<ul>
  <li><strong>Days 1–30:</strong> GBP optimization complete, first citation wave submitted, review request system implemented. 8–12 new reviews collected. Baseline rankings documented.</li>
  <li><strong>Days 31–60:</strong> City pages live on website, schema markup implemented. GBP posts active weekly. First measurable movement in Map Pack rankings for lower-competition keywords.</li>
  <li><strong>Days 61–90:</strong> Citation signals fully indexed. Review count growing. 2–5 new inbound calls/month attributable to organic search. Movement on primary keywords beginning.</li>
</ul>
<p>Month 6 is typically when the compound effect kicks in — when rankings stabilize in the top 3 for primary keywords, and the inbound call volume from organic search becomes a consistent, predictable channel rather than occasional luck.</p>
<p>If you want to see exactly where your agency stands today — which keywords you're ranking for, where your competitors are outranking you, and what specific gaps exist in your local SEO — <a href="/local-seo-for-home-care-agencies/">request a free local SEO audit from Homecare Creators</a>. We'll give you a complete picture of your current position and a clear roadmap to page one.</p>
HTML;

// ── BLOG POST 5 ───────────────────────────────────────────────────────────────
$post5_content = <<<'HTML'
<h2 id="hard-truth">The Hard Truth About Home Care Agency Marketing in 2025</h2>
<p>The home care industry in Florida is growing fast — and so is the competition for the clients who matter most. Private-pay families with long-term care needs, hospital discharge planners who control referral streams, and adult children doing late-night Google searches are all up for grabs. The agencies winning those clients aren't necessarily the ones with the best caregivers, the most experience, or the most competitive rates.</p>
<p>They're the ones who figured out digital marketing before their competitors did.</p>
<p>Having worked with home care agencies across Florida, we've identified a pattern: the same 6 mistakes appear in almost every agency that's struggling to grow online. And the agencies that are thriving? They've avoided every single one. Here's what separates them.</p>

<h2 id="mistake-1-word-of-mouth">Mistake #1: Relying on Word-of-Mouth Alone</h2>
<p>Word-of-mouth is beautiful when it works. A hospital discharge planner who loves you sends you 5 clients a month. A satisfied family tells their friends. Referrals arrive organically and feel like validation.</p>
<p>It's also the most fragile marketing channel you can have. Your champion discharge planner retires or moves to a different hospital. Your best referral source moves to a competing agency. A single difficult client situation creates a ripple of negative word-of-mouth. Suddenly your pipeline is dry — and you have no marketing infrastructure to fill it.</p>
<p>Thriving agencies treat word-of-mouth as a bonus, not a business model. Their baseline is a digital presence that generates consistent, predictable inbound leads regardless of what any individual referral source does. Word-of-mouth supplements a system; it's not a replacement for one.</p>

<h2 id="mistake-2-ads-before-foundation">Mistake #2: Spending Money on Ads Before Fixing the Foundation</h2>
<p>This is the most expensive mistake in home care marketing. An agency owner gets frustrated with slow growth, spends $2,000/month on Google Ads, gets 15 clicks to their website — and converts zero of them because the website is slow, generic, and gives families no reason to call.</p>
<p>Paid ads amplify whatever is already there. If what's there is weak — a slow website, no reviews, a generic value proposition, no clear CTA — paid ads amplify weakness. You're spending money to send families to a website that loses them.</p>
<p>The foundation must come first: a fast, trust-building website with clear CTAs; a Google Business Profile with 25+ reviews; a review collection system that keeps reviews coming in; and local SEO basics that generate organic traffic. Once that foundation generates a consistent baseline of leads, paid ads can amplify it profitably. Running ads before the foundation is built is burning money.</p>

<h2 id="mistake-3-brochure-website">Mistake #3: Having a "Brochure" Website Instead of a Sales Machine</h2>
<p>A brochure website says: here's who we are, here's what we do, here's our contact information. It's a digital version of handing someone a pamphlet.</p>
<p>A sales machine says: I understand exactly what you're going through. Here's what makes us different. Here's what other families in your situation said about us. Here's exactly what happens when you call. Here's the button to call right now.</p>
<p>The difference isn't just design. It's psychology. A family landing on your website in a moment of crisis is not calmly browsing — they're scared, overwhelmed, and looking for reassurance. The brochure website makes them do work to determine if you're trustworthy. The sales machine does that work for them, immediately, in the first 30 seconds of their visit.</p>
<p>Ask yourself: if a family landed on your homepage right now with no prior knowledge of your agency, would they call you within 60 seconds? If the honest answer is "probably not" — your website is the single biggest constraint on your growth.</p>

<h2 id="mistake-4-ignoring-local-seo">Mistake #4: Ignoring Local SEO Entirely</h2>
<p>Some agency owners have decided that "SEO takes too long" or "we tried it and it didn't work." Almost always, what they tried was generic SEO from a generalist agency that treated their home care business like any other local service company — the same approach they use for plumbers and electricians.</p>
<p>Home care SEO is a specific discipline. The keywords families use to find home care are different from the keywords people use to find a plumber. The directories that matter are different. The trust signals that move the needle — reviews from families, healthcare-specific citations, schema markup for healthcare businesses — are different.</p>
<p>Local SEO done correctly for a home care agency — with city-specific pages, Google Business Profile optimization, healthcare directory citations, and a systematic review strategy — will generate qualified leads month after month at a fraction of the cost of paid advertising. The agencies that "tried SEO and it didn't work" almost always worked with an agency that didn't understand the home care industry specifically.</p>

<h2 id="mistake-5-wrong-audience">Mistake #5: Trying to Market to Everyone Instead of Your Ideal Client</h2>
<p>Home care agencies serve everyone — young people recovering from surgery, adults with disabilities, and seniors needing companionship. Marketing to all of them equally means your messaging is specific to none of them.</p>
<p>The agencies with the best marketing have made a deliberate choice about their primary client profile and built their entire digital presence around that profile. An agency focused on Alzheimer's and dementia care uses different messaging, different keywords, different testimonials, and different content than an agency focused on post-surgical recovery care — even if both agencies technically offer both types of care.</p>
<p>Specificity in marketing isn't limiting. It's magnetic. Families searching for "dementia care specialist near me" will choose the agency whose entire website screams "we specialize in dementia care" over the agency that lists dementia as one of twelve services.</p>
<blockquote>The riches are in the niches — and in home care, the agency that's known for something specific will always win more of that segment than the agency trying to be everything to everyone.</blockquote>

<h2 id="mistake-6-giving-up-on-seo">Mistake #6: Giving Up on SEO After 30 Days</h2>
<p>Local SEO is a long game. This is not a bug — it's a feature. The reason SEO generates such high ROI over time is precisely because most competitors give up before it works. They invest for 60–90 days, don't see page-one rankings, conclude "SEO doesn't work," and go back to word-of-mouth and expensive paid ads.</p>
<p>This creates a massive opportunity for the agencies that understand the compounding nature of SEO. Every piece of content published, every citation built, every review collected, every backlink earned — these don't expire. They accumulate. An agency that invests consistently in SEO for 12 months builds a moat that's very difficult for a competitor who started 3 months ago to close.</p>
<p>The agencies ranking at the top of Google Maps in Miami, Tampa, and Orlando didn't get there overnight. They made a long-term decision to invest in organic visibility — and now they're reaping monthly dividends that cost them almost nothing to maintain.</p>

<h2 id="what-top-agencies-do">What the Top 13% of Home Care Agencies Do Differently</h2>
<p>After working with home care agencies across Florida, the pattern of what separates the high-growth agencies from the struggling ones is remarkably consistent. The top performers share these habits:</p>
<ul>
  <li><strong>They have a real website that converts.</strong> Not a template. Not a brochure. A fast, mobile-optimized site built around how families make decisions, with clear CTAs and strong social proof above the fold.</li>
  <li><strong>They systematically collect reviews.</strong> They have a process. Someone is responsible for it. Every satisfied family is asked within 48 hours of expressing happiness with their care.</li>
  <li><strong>They publish content regularly.</strong> They know that every blog post is a new entry point into their website — another question answered for a family who's researching, another keyword ranked for, another reason for Google to trust their domain.</li>
  <li><strong>They measure what matters.</strong> They know their cost per lead, their lead-to-consultation conversion rate, and their close rate. They know which marketing channels are producing ROI and which aren't.</li>
  <li><strong>They invest before they need to.</strong> They don't wait for the pipeline to dry up to start thinking about marketing. They treat marketing investment as overhead — a necessary cost of staying in business and growing.</li>
  <li><strong>They work with specialists, not generalists.</strong> The top agencies work with marketing partners who understand the home care industry specifically — not agencies that run ads for restaurants and dentists and home care agencies all with the same playbook.</li>
</ul>

<h2 id="compound-roi">The Compounding ROI of Getting Your Digital Foundation Right</h2>
<p>Here's the math that most agency owners don't calculate until it's too late to take advantage of it.</p>
<p>If a properly built SEO foundation generates 5 additional inbound leads per month — and your consultation-to-client conversion rate is 30% — that's 1.5 new clients per month. If an average client generates $3,000/month and stays for 14 months, each new client is worth $42,000 in lifetime revenue.</p>
<p>1.5 new clients/month × $42,000 lifetime value = <strong>$63,000 in new annual pipeline</strong> from organic search alone.</p>
<p>And unlike paid ads, those rankings don't cost more as you grow. The marginal cost of the 10th lead from SEO is the same as the marginal cost of the 1st lead — nearly zero.</p>
<p>Now consider what happens at month 18, when your review count is twice what it was, your content has accumulated more rankings, and your domain authority has compounded. Your lead volume from organic search is higher. Your cost per lead is lower. And the agency that was outranking you 18 months ago — because they started investing before you — is now your peer.</p>
<p>That's the compounding ROI of a solid digital foundation. It just requires the patience and discipline to build it correctly from the start.</p>
<p>At <a href="/">Homecare Creators</a>, we specialize exclusively in marketing home care agencies across Florida. We've helped agencies in Miami, Tampa, Orlando, Jacksonville, and beyond build the digital foundation that generates consistent, predictable private-pay leads month after month. If you're ready to stop making the mistakes above and start building what the top 13% have built, <a href="/local-seo-for-home-care-agencies/">start with a free SEO audit</a>.</p>
HTML;

// ── INSERT ALL POSTS ──────────────────────────────────────────────────────────
$posts = [
    [
        'title'              => "Why Your Home Care Agency Isn't Showing Up on Google — And How to Fix It in 90 Days",
        'slug'               => 'why-home-care-agency-not-showing-up-google',
        'excerpt'            => "Most home care agencies in Florida are invisible on Google — not because of poor service, but because of five fixable mistakes. Here's exactly what's stopping you from ranking and what to do about it.",
        'content'            => $post1_content,
        'author'             => 'Homecare Creators',
        'focus_keyword'      => 'home care agency SEO',
        'secondary_keywords' => 'home care not showing up Google, local SEO home care, home care Google ranking, home care agency visibility',
        'meta_title'         => "Why Your Home Care Agency Isn't on Google (And How to Fix It) | Homecare Creators",
        'meta_desc'          => 'Discover the 5 reasons your home care agency isn\'t appearing in Google search results — and a practical 90-day roadmap to fix every one of them.',
        'status'             => 'published',
        'published_at'       => '2026-06-20 09:00:00',
    ],
    [
        'title'              => "The Private-Pay Client Formula: How Florida Home Care Agencies Are Winning High-Value Cases",
        'slug'               => 'private-pay-home-care-clients-florida',
        'excerpt'            => "Private-pay clients are the key to a profitable home care agency — and the families who pay out-of-pocket start their search on Google. Here's the exact 5-step system top Florida agencies use to attract and convert them.",
        'content'            => $post2_content,
        'author'             => 'Homecare Creators',
        'focus_keyword'      => 'private pay home care clients',
        'secondary_keywords' => 'how to get private pay home care clients, private duty home care marketing, Florida home care agency growth, attract private pay clients',
        'meta_title'         => 'How to Get Private-Pay Home Care Clients in Florida | Homecare Creators',
        'meta_desc'          => 'The 5-step formula Florida home care agencies use to attract high-value private-pay clients through local SEO, a trust-first website, and a systematic review strategy.',
        'status'             => 'published',
        'published_at'       => '2026-06-23 09:00:00',
    ],
    [
        'title'              => "Home Care Agency Website Design: 11 Things Your Site Must Have to Convert Families in 2025",
        'slug'               => 'home-care-website-design-must-haves',
        'excerpt'            => "Most home care websites fail to convert families — not because of poor design, but because they're built around the agency instead of the family's psychology. Here are the 11 elements your site needs to turn visitors into consultations.",
        'content'            => $post3_content,
        'author'             => 'Homecare Creators',
        'focus_keyword'      => 'home care agency website design',
        'secondary_keywords' => 'home care website must haves, home care website conversion, homecare website design Florida, what home care website needs',
        'meta_title'         => 'Home Care Agency Website Design: 11 Must-Have Elements for 2025 | Homecare Creators',
        'meta_desc'          => "Is your home care website actually generating leads — or just sitting there? Here are the 11 elements every agency site must have to convert families into consultation calls.",
        'status'             => 'published',
        'published_at'       => '2026-06-25 09:00:00',
    ],
    [
        'title'              => "Local SEO for Home Care Agencies: How to Rank #1 on Google Maps in Your Florida City",
        'slug'               => 'local-seo-home-care-agency-google-maps',
        'excerpt'            => "The Google Maps Pack is where families choose their home care agency. Here's the complete, step-by-step guide to ranking in the top 3 for your Florida city — from Google Business Profile optimization to review strategy to local citations.",
        'content'            => $post4_content,
        'author'             => 'Homecare Creators',
        'focus_keyword'      => 'local SEO home care agency',
        'secondary_keywords' => 'home care agency Google Maps ranking, local SEO Florida home care, Google Business Profile home care, home care citations',
        'meta_title'         => 'Local SEO for Home Care Agencies: Rank #1 on Google Maps in Florida | Homecare Creators',
        'meta_desc'          => 'A complete local SEO guide for Florida home care agencies — step-by-step instructions for ranking in the Google Maps Pack, building reviews, and dominating local search.',
        'status'             => 'published',
        'published_at'       => '2026-06-27 09:00:00',
    ],
    [
        'title'              => "The Real Reason Most Home Care Agencies Fail at Marketing (And What the Top Performers Do Differently)",
        'slug'               => 'home-care-agency-marketing-mistakes',
        'excerpt'            => "After working with home care agencies across Florida, we've identified the same 6 marketing mistakes in almost every struggling agency — and the habits that separate the high-growth agencies from everyone else.",
        'content'            => $post5_content,
        'author'             => 'Homecare Creators',
        'focus_keyword'      => 'home care agency marketing',
        'secondary_keywords' => 'home care marketing strategy, home care marketing mistakes, how to market home care agency, home care digital marketing Florida',
        'meta_title'         => 'Why Home Care Agencies Fail at Marketing — And What Top Performers Do Differently | Homecare Creators',
        'meta_desc'          => "6 marketing mistakes that keep home care agencies stuck — and the 6 habits of Florida's fastest-growing agencies. Which camp does yours fall into?",
        'status'             => 'published',
        'published_at'       => '2026-06-30 09:00:00',
    ],
];

$inserted = 0;
$updated  = 0;
foreach ($posts as $p) {
    $existing = hc_one("SELECT id FROM hc_blog_posts WHERE slug = ?", [$p['slug']]);
    if ($existing) {
        hc_q("UPDATE hc_blog_posts SET title=?,excerpt=?,content=?,author=?,focus_keyword=?,secondary_keywords=?,meta_title=?,meta_desc=?,status=?,published_at=? WHERE slug=?",
            [$p['title'],$p['excerpt'],$p['content'],$p['author'],$p['focus_keyword'],$p['secondary_keywords'],$p['meta_title'],$p['meta_desc'],$p['status'],$p['published_at'],$p['slug']]);
        $updated++;
    } else {
        hc_q("INSERT INTO hc_blog_posts (title,slug,excerpt,content,author,focus_keyword,secondary_keywords,meta_title,meta_desc,status,published_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)",
            [$p['title'],$p['slug'],$p['excerpt'],$p['content'],$p['author'],$p['focus_keyword'],$p['secondary_keywords'],$p['meta_title'],$p['meta_desc'],$p['status'],$p['published_at']]);
        $inserted++;
    }
}
?>
<!DOCTYPE html>
<html><head><style>body{font-family:sans-serif;max-width:640px;margin:60px auto;padding:0 20px}</style></head><body>
<h2>Blog Seeder Complete</h2>
<p>Inserted: <strong><?= $inserted ?></strong> | Updated: <strong><?= $updated ?></strong></p>
<ul>
<?php foreach ($posts as $p): ?>
<li><a href="/blog/post.php?slug=<?= urlencode($p['slug']) ?>" target="_blank"><?= htmlspecialchars($p['title']) ?></a></li>
<?php endforeach ?>
</ul>
<p style="color:#888;margin-top:24px">Delete this file from the server after confirming the posts look correct.</p>
</body></html>
