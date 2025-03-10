@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- breadcrumb-area -->
	<section class="breadcrumb-area breadcrumb-bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-content">
						<h2 class="title">About LEI</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">About LEI</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumb-shape-wrap">
			<img src="assets/img/images/breadcrumb_shape01.png" alt="">
			<img src="assets/img/images/breadcrumb_shape02.png" alt="">
		</div>
	</section>
	<!-- breadcrumb-area-end -->

	<!-- faq-area -->
	<section class="faq-area section-py-120">
		<div class="container">
			<div class="row align-items-end justify-content-center">
				<div class="col-lg-12">
					<div class="faq-content">
						<div class="section-title mb-30 tg-heading-subheading animation-style2">
							<h2 class="title tg-element-title">What is the Legal Entity Identifier?</h2>
						</div>
						<p>The Legal Entity Identifier (LEI) is a unique identifier, which allows for the identification of legally independent entities across global financial markets. It represents an innovative cross-country, cross-legal system, and cross-market solution. The creation of the Global LEI System is a direct result of the recent financial crisis and a reaction to the difficulties experienced by banks and regulatory agencies to quickly identify complex corporate relationships as well as links between issuers and securities.</p>
						<h2>Frequently asked Questions on the LEI</h2>
						<p>Here you find help and answers to frequent questions on specific products and services related to the Legal Entity Identifiers (LEIs), their application, costs, renewal or the change of the account.</p>
						<div class="accordion-wrap">
							<div class="accordion" id="accordionExample">
								<div class="accordion-item">
									<h2 class="accordion-header">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											What is the format of the LEI?
										</button>
									</h2>
									<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<p>The LEI format is based on ISO Standard 17442 and follows Financial Stability Board (FSB) specifications. The LEI consists of a 20-digit alphanumeric code.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										How do markets benefit from the LEI?
									</button>
									</h2>
									<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<p>With the global establishment of a uniform system for the identification of legal entities, it is expected that costs will be reduced for individual companies as well as the entire market and that the risks management and financial market transparency will be improved.</p>
											<p>This can be achieved through error reductions with regard to business transactions and by lowering the costs for data cleaning, maintenance, and reporting to regulatory authorities. In addition, the clear identification of all contracting partners strengthens important business processes and reduces risks for all involved companies.</p>
										</div>
									</div>
								</div>
							<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Who is behind the LEI system and how is it organized?
								</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>The Financial Stability Board (FSB), a regulatory committee located in Basel, established the LEI system on behalf of the G20. The objective is to be able to quickly and reliably identify each party involved in a financial transaction (as well as each fund) with the help of a unique identifier. The LEI system is monitored by the Legal Entity Identifier Regulatory Oversight Committee (LEI ROC (www.leiroc.org)), which consists of more than 50 regulatory institutions worldwide and a variety of public sector stakeholders.</p>

										<p>With the creation of the Global LEI Foundation (GLEIF (www.gleif.org)) as the administrative center of the Global LEI System (GLEIS) in June 2014, an important step towards the establishment of a system of global entity identification was taken. The GLEIF governs the global implementation of the worldwide uniform GLEIS standards. Various different Local Operation Units (LOUs) are responsible for the allocation of LEIs. They contribute their expertise with regard to local structures and jurisdictions and assure that the information provided by companies and funds is transferred correctly to the global system.</p>

										<p>More information on the structure of the LEI and on relevant organizations can be found on the websites of the FSB (www.financialstabilityboard.org), the LEI (www.leiroc.org), or the GLEIF (www.gleif.org).</p>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									What is the global Legal Entity Identifier (LEI)?
								</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>The Legal Entity Identifier (LEI) is an internationally standardized and globally valid identifier for financial market participants. Its purpose is to clearly and unequivocally identify contracting parties (e.g., companies, banks, and investment funds). It is used to comply with a variety of financial reporting requirements. It represents an innovative cross-country, cross-legal system, and cross-market solution.</p>

										<p>The creation of the Global LEI System is a direct result of the recent financial crisis and a reaction to the difficulties experienced by banks and regulatory agencies to quickly identify complex corporate relationships as well as links between issuers and securities</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									What is the area of application of the LEI?
								</button>
								</h2>
								<div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>On July 4, 2012, European authorities signed into law Regulation (EU) No 648/2012 of the European Parliament and of the Council on OTC derivatives, central counterparties, and trade repositories (EMIR). The text is the result of an EU initiative on the regulation of OTC trading with derivative products. At the core of the regulation is the requirement for market participants to clear any derivative contracts through a central counterparty and to report any OTC derivative contracts to a trade repository. As EU regulation, EMIR is directly applicable and does not require any transposition into national law.</p>

										<p>The EMIR reporting requirement became effective on February 12, 2014, and applies to all derivative contracts that</p>

										<p>a.) were entered into before August 16, 2012, and remain outstanding on that date;</p>
										<p>b.) are entered into on or after August 16, 2012.</p>

										<p>Additional information on EMIR and the corresponding reporting requirements can be found on the website of the German Federal Financial Supervisory Authority (BaFin (www.bafin.de)).</p>

										<p>Details on the extent of the required reporting to the trade repositories can be located in the definition section of the Regulatory Technical Standards (RTS) issued by the European Securities and Markets Authority (ESMA) which were published on September 27, 2012. In addition to contract-specific data, the parties involved are also required to report basic information. An LEI is needed for the proper identification of the contracting parties in this context.</p>

										<p>An LEI is required for the compliance with European and international regulations, such as the CRD IV, EMIR, Solvency II, and the Dodd-Frank Act and has thus become an integral part of reporting in many areas of the financial sphere. Moreover, the LEI has already been mentioned in other regulations as, for instance, in the Technical Standards pertaining to the AIFMD (Alternative Investment Fund Managers Directive) or in the context of MiFID II (Markets in Financial Instruments Directive II)/ MiFIR (Markets in Financial Instruments Regulation).</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
									Which Regulations Require the Use of a LEI?
								</button>
								</h2>
								<div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>For more information see: <a href="www.gleif.org/rulemaking">www.gleif.org/rulemaking</a></p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseSev" aria-expanded="false" aria-controls="collapseSev">
									Which entity information is recorded along with the LEI?
								</button>
								</h2>
								<div id="collapseSev" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Each LEI record contains the following information about a company or fund:</p>
										<ul>
											<li>Official name of the legal entity / of the fund manager</li>
											<li>Legal form</li>
											<li>Commercial register number and name of the register</li>
										<li>Legal domicile of the administrative office / of the fund manager</li>
										<li>ISO country code (e.g. DE)</li>
										<li>Date of the initial LEI registration</li>
										<li>Date of the last information update</li>
										<li>Additional information may be added in the process of the further development of the standard.</li>
										</ul>
										<p>Additional information may be added in the process of the further development of the standard.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseEi" aria-expanded="false" aria-controls="collapseEi">
									What changes will take place regarding the representation of names for LEIs from October 2024?
								</button>
								</h2>
								<div id="collapseEi" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Starting in October 2024, there will be a change in the collection and representation of legal entity names associated with the Legal Entity Identifier (LEI).</p>

										<p><strong>How will the names be collected from October 2024?</strong></p>
										<p>The names of legal entities associated with an LEI will be recorded in the local language of the entity, provided that this information is clearly available from trade or fund registers or other official documentation. In addition, alternative names in other languages as well as trade or business names can be recorded in specially designated fields.</p>
										<p><strong>Why is this change being introduced?</strong></p>
										<p>This change is aimed at improving data quality and transparency by ensuring that the names of legal entities are recorded and displayed in their local language. This facilitates the identification of entities globally and enhances the user-friendliness of the LEI database.</p>
										<p><strong>Which organizations are responsible for this change?</strong></p>
										<p>The Legal Entity Identifier Regulatory Oversight Committee (LEI ROC) and the Global Legal Entity Identifier Foundation (GLEIF) have initiated this change. Implementation will be carried out by LEI issuing organizations (LOUs) such as WM Datenservice.</p>
										<p><strong>Do companies that already have an LEI need to take action?</strong></p>
										<p>No, there is no need for companies to take any action. WM Datenservice will take the necessary steps to update the data. If any action is required by the companies, WM Datenservice will contact the affected entities directly.</p>
										<p><strong>Will the additional names also be displayed in the WM-LEIPORTAL?</strong></p>
										<p>Yes, the display of the additional names is currently being updated and will soon be available in the WM-LEIPORTAL.</p>
										<p><strong>Will the alternative name automatically be recorded in English?</strong></p>
										<p>No, there is no requirement for the alternative name to be recorded in English. The alternative name can be provided in any language that is relevant to the legal entity.</p>
										<p><strong>Will existing LEIs be updated automatically?</strong></p>
										<p>Yes, WM Datenservice will carry out the necessary updates for existing LEIs. Should any specific action be required, WM Datenservice will contact the affected legal entities.</p>
										<p><strong>How does this change affect new LEI applications?</strong></p>
										<p>For new LEI applications, from October 2024, the names of legal entities must be provided both in the local language and in additional language and name fields. This review and recording will be managed as part of the LEI verification process by WM Datenservice.</p>
										<p><strong>What benefits does this new regulation offer?</strong></p>
										<p>The regulation enhances international transparency and facilitates the identification of legal entities across language barriers. This leads to better data quality and increases the usefulness of the global LEI system.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
									Who assigns the LEI?
								</button>
								</h2>
								<div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>The LEI is assigned based on a federal principle by local institutions (so-called Local Operating Units or LOU). As LOU, WM Datenservice has been responsible for the allocation of the LEI since April 2013. On October 3, 2013, the LEI ROC officially endorsed WM Datenservice. As a result, the LEIs assigned by WM Datenservice are recognized by all members of the LEI ROC and can be used globally for regulatory purposes (especially for reporting pursuant to EMIR and the Dodd-Frank Act). WM Datenservice has been a GLEIF-accredited LEI issuer since 13 April 2017.</p>

										<p>In its capacity as the sponsoring authority, The Federal Financial Supervisory Authority (BaFin) monitors and ensures the adherence to FSB and LEI ROC standards.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
									What type of company is WM Datenservice?
								</button>
								</h2>
								<div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>WM Datenservice (<a href="(www.wmdaten.com)" target="_blank">www.wmdaten.com)</a> is one of the leading data providers for the German financial industry. In addition to the LEI, the company also assigns other financial identifiers, such as the German Securities Code (Wertpapierkennnummer/ WKN) and the International Securities Identification Number (ISIN) to securities issued by German issuers. All LEIs assigned by WM Datenservice begin with the four-digit prefix (LOU identifier) 5299.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseEl" aria-expanded="false" aria-controls="collapseEl">
									Who requires an LEI?
								</button>
								</h2>
								<div id="collapseEl" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Which legal entities are required to have an LEI is determined by national and international laws. It is expected that the LEI will be required globally by many authorities and institutions to better be able to regulate the financial markets.</p>

										<p>In accordance with the applicable ISO standards, LEIs may currently only be assigned to legally independent entities, but not to natural persons.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseTw" aria-expanded="false" aria-controls="collapseTw">
									How does one apply for an LEI?
								</button>
								</h2>
								<div id="collapseTw" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>The application process can be initiated online via the WM LEIPORTAL (www.wm-leiportal.org) or the bulk application procedure may be used. An LEI is only assigned after WM Datenservice has conducted a thorough review of the submitted application.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseThir" aria-expanded="false" aria-controls="collapseThir">
									Who can apply for an LEI?
								</button>
								</h2>
								<div id="collapseThir" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>As an applicant, you must meet the following requirements:

										<p>At the time of the application, you are either authorized based on your position (e.g. executive, manager, authorized signatory) to apply for an LEI on behalf of your company or the fund controlled by your company</p>
										OR
										<p>You were authorized by an authorized representative (e.g. executive, manager) by means of a written form of authorization to apply for an LEI.</p>
									</div>
								</div>
						</div>

						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFourT" aria-expanded="false" aria-controls="collapseFourT">
									Why is a written form of authorization required? What does it have to include?
								</button>
								</h2>
								<div id="collapseFourT" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>In its capacity as LEI allocation agency and in accordance with relevant guidelines, WM Datenservice diligently verifies the information submitted in regards to the applicant’s identity. Among other things, this verification is based on the data available at the relevant commercial register.</p>

										<p>In addition, the LEI application has to be completed by a person listed in the relevant commercial register record and authorized to represent the company, or by a person authorized via a written form of authorization, which was issued by a person listed in the relevant commercial register record and authorized to represent the company. The written form of authorization has to be submitted to us electronically in form of a PDF file.</p>

										<p>In case of any data discrepancies, WM Datenservice requires that the original copy of the written form of authorization be submitted. WM Datenservice reserves the right to hold off the allocation of the LEI until the original copy of the written form of authorization has been received.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#15" aria-expanded="false" aria-controls="15">
									What information is verified as part of the LEI application process?
								</h2>
								<div id="15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>In order to maintain the highest possible level of LEI data quality, the details you submit as part of the application process will be verified based on the data available from different public sources. This way, we ensure that only correct information is coded and recorded.</p>

										<p>We also make sure that an LEI has not already been assigned to the name and / or address of the company / fund you are applying for. If all information appears correct and if no duplicates exist, the LEI is assigned and published. You will be notified automatically via email once the identifier is published.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#16" aria-expanded="false" aria-controls="16">
									What other information is published along with the LEI?
								</button>
								</h2>
								<div id="16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Each LEI requires profile specific information which is published in the global LEI system.Companies</p>  
										<ul>
											<li></li>
											<li>Company Name</li>
										<li>Commercial Register</li>
										<li>Legal Form of the Company</li>
										<li>Legal Headquarters</li>
										<li>Administrative Headquarters</li>
										</ul>
										<p><strong>Funds </strong></p> 
										<ul>
											<li>Fund Name</li>
										<li>Fund Structure</li>
										<li>Fund Type</li>
										<li>Legal Form</li>
										<li>Register of the Fund</li>
										<li>Name and Legal Headquarters of the Asset Management Company</li>
										<li>Custodian</li>
										</ul>
										Fund Name
										Fund Structure
										Fund Type
										Legal Form
										Register of the Fund
										Name and Legal Headquarters of the Asset Management Company
										Custodian
										<p><strong>Legal entities under public law</strong></p> 
										<ul>
											<li>Name of the Legal Entity of Public Law</li>
											<li>Classification</li>
											<li>Commercial Register</li>
											<li>Legal Headquarters</li>
											<li>Administrative Headquarters</li>
										</ul>
										<p>General information like LEI status, date of initial allocation, date of last data change, managing allocation agency, expiration date, etc. is also published.</p>
										<p>Additional fields and information can be adjusted through the further development of the standard.</p>

										<p>As of May 2017, all companies wishing to apply for and/or to renew their LEIs are required by regulation to provide information on their group structure. Please see the FAQ below for further details.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#17" aria-expanded="false" aria-controls="17">
									What is information on the group structure?
								</button>
								</h2>
								<div id="17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>As supervisory and controlling body of all LEI allocation agencies the Global Legal Identifier Foundation (GLEIF) requires from 1 May 2017 information on the group structure, in other words information on the direct and the ultimate parent. The objective is not only to answer the question “Who is Who?“, but also “Who owns Whom?“ For details in this regard, please visit the following link: www.gleif.org/en/There are three different profiles available to indicate the group structure. If there exists a parent and you are able to provide the data, this is possible via the two profiles ”Parent With an LEI“ or ”Parent Without an LEI“. In case that information on the group structure cannot be provided, this must also be indicated during the application and renewal process.</p>

										<p>Until further notice, information on the group structure is only required for companies.</p>

										<p>There is currently no information to submit for LEIs in the profiles “Funds“ and “Legal Entity of Public Law“ as the relevant specifications by the  LEI ROC are not yet available. If the abovenamed entity is a joint venture, an associated company, a structured (non-consolidated) company or an international subsidiary, information on the parent is not required.</p>

										<p>Direct Parent: The direct parent is defined as the lowest level legal entity that prepares consolidated financial statements (absolutely necessary) that consolidate the abovementioned entity, based on the accounting definition of consolidation applying to this parent.</p>

										<p>Ultimate Parent: The ultimate parent is defined as the highest level legal entity (absolutely necessary) that prepares consolidated financial statements that consolidate the abovementioned entity, based on the accounting definition of consolidation applying to this parent.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#18" aria-expanded="false" aria-controls="18">
									Why am I unable to find my LEI via the WM LEIPORTAL search feature?
								</button>
								</h2>
								<div id="18" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Upon successful submission of your LEI application, your data record can be accessed via the LEI Search feature. However, at this time no LEI has been assigned yet. Before assigning and publishing the LEI, WM Datenservice diligently verifies all data submitted as part of the application process.</p>

										<p>Data verification commences when your payment has been received in full. The time required for the data verification process varies from case to case and is dependent on the total current order volume.</p>

										<p>Once the data verification process has been successfully completed, your LEI will be published via the WM LEIPORTAL (go to LEI SEARCH | LEI Search (WM Datenservice) and you will be sent an email to confirm the publication along with a link to your LEI record.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#19" aria-expanded="false" aria-controls="19">
									My company has its legal domicile in Germany, but it also does business abroad. Do I need an additional LEI from the relevant allocation agency abroad?
								</button>
								</h2>
								<div id="19" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>No, each individual legal entity is only assigned one LEI, which can be used worldwide.

										<p>You only require an additional LEI if a foreign-based legally independent subsidiary needs an LEI for any financial market transactions or to comply with any reporting requirements.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#20" aria-expanded="false" aria-controls="20">
									My LEI application has been denied. What could be the reasons?
								</button>
								</h2>
								<div id="20" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Prior to assigning an LEI, we carefully review and verify the information provided by you during the application process. We also check if an LEI has already been assigned by another allocation agency.</p>

										<p>Should an LEI have been assigned already, or should we determine that incorrect or incomplete information was provided during the application process, no LEI is assigned or published. We will inform you via email about the reasons of why your LEI application has been denied.</p>

										<p>Our LEI-Helpdesk will contact you if we need additional information or clarification regarding your application.</p>
									</div>
								</div>
						</div>
						<div class="accordion-item">
								<h2 class="accordion-header">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#21" aria-expanded="false" aria-controls="21">
									Can individuals acting in a business capacity apply for an LEI?
								</button>
								</h2>
								<div id="21" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Yes, it is possible for individuals acting in a business capacity (registered merchants; traders registered in the commercial register) to apply for an LEI with WM Datenservice.Please note that an already existing entry in the respectively responsible trade and/or commercial register is required for a successful LEI application and allocation.</p>

										<p>A certified extract of the commercial register is a mandatory requirement of the LEI allocation to traders.</p>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<!-- faq-area-end -->



</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection