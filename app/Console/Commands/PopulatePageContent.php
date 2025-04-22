<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use Illuminate\Support\Facades\File;

class PopulatePageContent extends Command
{
    protected $signature = 'pages:populate';
    protected $description = 'Populate page content from view files';

    public function handle()
    {
        $this->info('Populating page content...');

        // About page
        $this->populatePage('about', 'About Us', $this->getAboutContent());
        
        // About LEI page
        $this->populatePage('about-lei', 'What is LEI', $this->getAboutLeiContent());
        
        // Contact page
        $this->populatePage('contact', 'Contact', $this->getContactContent());
        
        // Registration LEI page
        $this->populatePage('registration-lei', 'Registration LEI', $this->getRegistrationLeiContent());

        $this->info('Done!');
        return 0;
    }

    private function populatePage($slug, $name, $content)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page) {
            // Only update if content is empty
            if (empty($page->content) || $page->content === '[]') {
                // Prepare content based on page type
                if ($slug === 'about') {
                    $pageContent = [
                        'main_content' => '<p>At Bedford Capital, we are dedicated to simplifying the Legal Entity Identifier (LEI) registration and renewal process for businesses, financial institutions, and organizations worldwide. We understand the importance of regulatory compliance in today\'s financial landscape, and our goal is to provide a seamless, efficient, and transparent solution for obtaining and managing your LEI.</p>
                        
                        <h2>Who We Are</h2>
                        <p>Bedford Capital is a trusted provider of LEI registration services, helping businesses meet international financial regulations. With a team of experienced professionals and a deep understanding of global compliance requirements, we ensure that our clients receive fast, reliable, and cost-effective LEI solutions.</p>
                        
                        <h2>Our Mission</h2>
                        <p>Our mission is to empower businesses by making LEI registration and management simple, secure, and accessible. We believe in removing bureaucratic barriers and providing a streamlined process that saves time and effort.</p>
                        
                        <h2>What We Offer</h2>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> New LEI Registration – Quick and hassle-free application process for first-time LEI registrations.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> LEI Renewal & Transfer – Easy renewal and transfer of existing LEIs to ensure continuous compliance.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Competitive Pricing – Affordable rates with no hidden fees or unexpected charges.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Regulatory Compliance Assurance – Stay compliant with financial regulations, including MiFID II, EMIR, and other global mandates.</li>
                            </ul>
                        </div>

                        <h2>Why Choose Us?</h2>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Speed & Efficiency – Get your LEI issued or renewed in just a few hours.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Global Reach – We serve clients across multiple industries and countries.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Security & Transparency – Your data is protected with the highest security standards.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> User-Friendly Platform – A simple and intuitive system to manage your LEI with ease.</li>
                            </ul>
                        </div>
                        
                        <p>At Bedford Capital, we are committed to providing top-notch LEI services so you can focus on what matters most—growing your business. Let us handle your LEI registration while you stay compliant and worry-free.</p>',
                        'faqs' => [
                            [
                                'question' => 'How long does it take to get an LEI?',
                                'answer' => '<p>With Bedford Capital, most LEIs are issued within 24 hours after application and verification.</p>'
                            ],
                            [
                                'question' => 'How much does an LEI cost?',
                                'answer' => '<p>Our pricing is transparent with no hidden fees. One-year registrations start at €75, with discounts for multi-year plans.</p>'
                            ]
                        ]
                    ];
                } 
                elseif ($slug === 'about-lei') {
                    // Similar structure for about-lei page
                    $pageContent = [
                        'main_content' => '<div class="section-title mb-30 tg-heading-subheading animation-style2">
                            <h2 class="title tg-element-title">What is the Legal Entity Identifier?</h2>
                        </div>
                        <p>The Legal Entity Identifier (LEI) is a unique identifier, which allows for the identification of legally independent entities across global financial markets. It represents an innovative cross-country, cross-legal system, and cross-market solution. The creation of the Global LEI System is a direct result of the recent financial crisis and a reaction to the difficulties experienced by banks and regulatory agencies to quickly identify complex corporate relationships as well as links between issuers and securities.</p>
                        <h2>Frequently asked Questions on the LEI</h2>
                        <p>Here you find help and answers to frequent questions on specific products and services related to the Legal Entity Identifiers (LEIs), their application, costs, renewal or the change of the account.</p>',
                        'faqs' => [
                            [
                                'question' => 'What is the format of the LEI?',
                                'answer' => '<p>The LEI format is based on ISO Standard 17442 and follows Financial Stability Board (FSB) specifications. The LEI consists of a 20-digit alphanumeric code.</p>'
                            ],
                            [
                                'question' => 'How do markets benefit from the LEI?',
                                'answer' => '<p>With the global establishment of a uniform system for the identification of legal entities, it is expected that costs will be reduced for individual companies as well as the entire market and that the risks management and financial market transparency will be improved.</p>
                                <p>This can be achieved through error reductions with regard to business transactions and by lowering the costs for data cleaning, maintenance, and reporting to regulatory authorities. In addition, the clear identification of all contracting partners strengthens important business processes and reduces risks for all involved companies.</p>'
                            ]
                        ]
                    ];
                }
                elseif ($slug === 'contact') {
                    $pageContent = [
                        'main_content' => '<h2 class="title">Our Office Address</h2>
                        <div class="contact-info-item">
                            <h5 class="title-two">UK Office</h5>
                            <ul class="list-wrap">
                                <li>International House <br>6 South Molton St. London EW1K 5QF,<br> United Kingdom</li>
                                <li>+44 20 8040 0288</li>
                                <li>info@lei-register.co.uk</li>
                            </ul>
                        </div>'
                    ];
                }
                elseif ($slug === 'registration-lei') {
                    $pageContent = [
                        'main_content' => '<h2>LEI Register Services</h2>
                        <p>Secure your Legal Entity Identifier with our trusted registration service</p>'
                    ];
                }
                else {
                    $pageContent = ['main_content' => $content];
                }
                
                $page->content = json_encode($pageContent);
                $page->save();
                $this->info("Updated content for {$name} page");
            } else {
                $this->info("{$name} page already has content, skipping");
            }
        } else {
            $this->error("{$name} page not found");
        }
    }

    private function getAboutContent()
    {
        return <<<'HTML'
<p>At Bedford Capital, we are dedicated to simplifying the Legal Entity Identifier (LEI) registration and renewal process for businesses, financial institutions, and organizations worldwide. We understand the importance of regulatory compliance in today's financial landscape, and our goal is to provide a seamless, efficient, and transparent solution for obtaining and managing your LEI.</p>

<h2>Who We Are</h2>
<p>Bedford Capital is a trusted provider of LEI registration services, helping businesses meet international financial regulations. With a team of experienced professionals and a deep understanding of global compliance requirements, we ensure that our clients receive fast, reliable, and cost-effective LEI solutions.</p>

<h2>Our Mission</h2>
<p>Our mission is to empower businesses by making LEI registration and management simple, secure, and accessible. We believe in removing bureaucratic barriers and providing a streamlined process that saves time and effort.</p>

<h2>What We Offer</h2>
<div class="about-list-two">
    <ul class="list-wrap">
        <li><img src="assets/img/icons/check_icon.svg" alt=""> New LEI Registration – Quick and hassle-free application process for first-time LEI registrations.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> LEI Renewal & Transfer – Easy renewal and transfer of existing LEIs to ensure continuous compliance.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Competitive Pricing – Affordable rates with no hidden fees or unexpected charges.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Regulatory Compliance Assurance – Stay compliant with financial regulations, including MiFID II, EMIR, and other global mandates.</li>
    </ul>
</div>

<h2>Why Choose Us?</h2>
<div class="about-list-two">
    <ul class="list-wrap">
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Speed & Efficiency – Get your LEI issued or renewed in just a few hours.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Global Reach – We serve clients across multiple industries and countries.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Security & Transparency – Your data is protected with the highest security standards.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
        <li><img src="assets/img/icons/check_icon.svg" alt=""> User-Friendly Platform – A simple and intuitive system to manage your LEI with ease.</li>
    </ul>
</div>
<p>At Bedford Capital, we are committed to providing top-notch LEI services so you can focus on what matters most—growing your business. Let us handle your LEI registration while you stay compliant and worry-free.</p>
HTML;
    }

    private function getAboutLeiContent()
    {
        // Extract relevant content from about-lei.blade.php
        // For brevity, I'm just showing the function - you would add the actual HTML from your template
        return <<<'HTML'
<div class="section-title mb-30 tg-heading-subheading animation-style2">
    <h2 class="title tg-element-title">What is the Legal Entity Identifier?</h2>
</div>
<p>The Legal Entity Identifier (LEI) is a unique identifier, which allows for the identification of legally independent entities across global financial markets. It represents an innovative cross-country, cross-legal system, and cross-market solution. The creation of the Global LEI System is a direct result of the recent financial crisis and a reaction to the difficulties experienced by banks and regulatory agencies to quickly identify complex corporate relationships as well as links between issuers and securities.</p>
<h2>Frequently asked Questions on the LEI</h2>
<p>Here you find help and answers to frequent questions on specific products and services related to the Legal Entity Identifiers (LEIs), their application, costs, renewal or the change of the account.</p>
<!-- Include the accordion content here -->
HTML;
    }

    private function getContactContent()
    {
        return <<<'HTML'
<h2 class="title">Our Office Address</h2>
<div class="contact-info-item">
    <h5 class="title-two">UK Office</h5>
    <ul class="list-wrap">
        <li>International House <br>6 South Molton St. London EW1K 5QF,<br> United Kingdom</li>
        <li>+44 20 8040 0288</li>
        <li>info@lei-register.co.uk</li>
    </ul>
</div>
HTML;
    }

    private function getRegistrationLeiContent()
    {
        // This one might be more complex, you may want to extract just some key content
        return <<<'HTML'
<h2>LEI Register Services</h2>
<p>Secure your Legal Entity Identifier with our trusted registration service</p>
HTML;
    }
}