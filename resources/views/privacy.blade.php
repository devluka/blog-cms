<x-blog-layout 
    :categories="$categories" 
    meta-title="Privacy Policy" 
    meta-description="Privacy Policy for Vertex."
>
    <div class="max-w-2xl mx-auto py-16 px-6">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">Privacy Policy</h1>
        
        <div class="prose prose-sm prose-gray dark:prose-invert font-serif">
            <p>Last updated: {{ date('F d, Y') }}</p>

            <h3>1. Introduction</h3>
            <p>Welcome to Vertex ("we," "our," or "us"). We respect your privacy and are committed to protecting your personal data.</p>

            <h3>2. Data We Collect</h3>
            <p>We may collect usage data, cookies, and analytics to improve the reading experience. If you contact us, we collect your email address.</p>

            <h3>3. How We Use Data</h3>
            <p>We use data to analyze website traffic and prevent fraud. We do not sell your personal data to third parties.</p>

            <h3>4. Contact Us</h3>
            <p>If you have questions, please contact us at <a href="mailto:hello@deployte.com">hello@deployte.com</a>.</p>
        </div>
    </div>
</x-blog-layout>