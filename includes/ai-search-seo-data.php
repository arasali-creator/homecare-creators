<?php
// Shared AI Search SEO pricing + FAQ data.
// Used by /ai-search-seo/ (visible page) and the admin schema scripts,
// so the prices and FAQ text in the schema always match the page.
return [
    'setup' => ['name' => 'AI Search Setup', 'price' => '997'],
    'addon' => ['name' => 'AI Search Add-on for SEO clients', 'price' => '497'],
    'plans' => [
        ['name' => 'AI Visibility Essentials', 'short' => 'Essentials', 'price' => '797'],
        ['name' => 'AI Visibility Growth',     'short' => 'Growth',     'price' => '1297'],
        ['name' => 'AI Visibility Authority',  'short' => 'Authority',  'price' => '1997'],
    ],
    'faqs' => [
        ['What is AI Search SEO (GEO/AEO), exactly?', 'Generative Engine Optimization (GEO) and Answer Engine Optimization (AEO) are the practices of structuring your website and content so tools like ChatGPT, Google AI Overviews, and Perplexity can understand, trust, and cite your agency when a family asks for a home care recommendation. Think of it as the AI-era counterpart to traditional SEO, built around how these tools actually pull and summarize information.'],
        ['How much does AI Search SEO cost?', 'Monthly plans start at $797/month (Essentials, 25 tracked family questions). Growth is $1,297/month and Authority is $1,997/month. Most agencies start with a one-time AI Search Setup for $997. If you are already one of our SEO clients, you can add AI search to your current plan for $497/month.'],
        ['How is this different from regular local SEO?', "Traditional SEO is built around ranking a page in a list of results for specific keywords. AI search optimization leans much more heavily on structured data, entity consistency, clear direct-answer content, and third-party authority signals, since that's what a generative model relies on to decide what to summarize and who to cite. We run both together, since they reinforce each other rather than compete."],
        ['What does the monthly AI visibility report measure?', 'We ask the AI tools the same set of family questions every month, such as "best home care in [your city]". The report shows how many of those questions mention your agency, on which AI tools (ChatGPT, Google AI Overviews and Perplexity, plus Gemini and Copilot on Authority), which competitors are named instead of you, and what we did and changed that month.'],
        ['How long does it take to show up in AI answers?', "Honestly, there's no fixed timeline the way there is for something like Google Maps rankings, since this is such a new field. Most agencies see early signals, like being pulled into an AI Overview or referenced by a chatbot, within a few months of consistent work. But the AI platforms control their own models and update them on their own schedule, so visibility can shift as those models change, not just based on our work."],
        ['Do you guarantee my agency will be cited by ChatGPT?', "No, and we won't pretend otherwise. No agency can honestly guarantee a placement inside a system it doesn't control. What we do guarantee is the work itself: building the structured data, entity signals, and answer-formatted content that give your agency a real, defensible shot at being included. Every engagement is also backed by our standard 30-day satisfaction guarantee."],
        ["What's included in the AI Search SEO service?", 'Every plan includes tracking of real family questions across AI tools, answer-style pages or FAQ updates, schema upkeep, and a monthly AI visibility report. Higher plans add more tracked questions, more content, third-party mentions and directory placements, competitor citation checks and a monthly strategy call. We coordinate all of it with your local SEO so both channels reinforce each other.'],
        ['Can this be bundled with local SEO or website design?', "Yes. Most agencies buy AI Search SEO alongside local SEO, since both draw on the same technical foundation and content. If you're already one of our SEO clients, the AI Search Add-on is $497/month and covers AI tracking, schema, and answer-formatting of the content we already produce for you."],
        ['Do you require a long-term contract?', 'No. Like the rest of our services, AI Search SEO starts with a 90-day ramp-up period so the foundational work, schema, entity data, and structured content, can be built properly. After that, everything moves to month-to-month.'],
    ],
];
