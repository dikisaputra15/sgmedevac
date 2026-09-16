@extends('layouts.master')

@section('title','Hospitals')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    #map {
        height: 700px;
    }
    .filter-container {
        margin-bottom: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .form-check-scrollable {
        max-height: 150px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }
    .total-hospital {
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.2);
        font-weight: bold;
    }
    .select2-container .select2-selection--single {
        height: 45px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
        right: 10px;
    }

     .p-modal{
        text-align:justify;
    }

       .btn-danger{
            background-color:#395272;
            border-color: transparent;
        }

        .btn-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .btn.active {
            background-color: #5686c3 !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        .p-3{
            padding: 10px !important;
            margin: 0 3px;
        }

        .btn-outline-danger{
            color: #FFFFFF;
            background-color:#395272;
            border-color: transparent;
        }

        .btn-outline-danger:hover{
            background-color:#5686c3;
            border-color: transparent;
        }

        .fa,
        .fab,
        .fad,
        .fal,
        .far,
        .fas {
            color: #346abb;
        }

        .card-header{
            padding: 0.25rem 1.25rem;
            color: #3c66b5;
            font-weight: bold;
        }

        .mb-4{
            margin-bottom: 0.5rem !important;
        }

        /* Classification */
        .advanced{
            border-bottom: 3px solid #397fff;
        }

        .intermediete{
            border-bottom: 3px solid #48d12c;
        }

        .basic{
            border-bottom: 3px solid #b4a911ff;
        }

        /* Boder */
        .bl{
            border-left: 2px solid #DDDDDD;
        }

        .br{
            border-right: 2px solid #DDDDDD;
        }

.info-modal-dialog {
    max-width: 1180px;
    width: 95vw;
    margin-left: auto;
    margin-right: auto;
}
.info-modal-dialog .modal-content {
    max-height: 88vh;
    border: none;
    border-radius: 10px;
    overflow: hidden;
}
.info-modal-dialog .modal-header {
    flex: 0 0 auto;
    background: #f8f9fa;
}

.info-modal-tabs {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    flex: 0 0 auto;
    flex-wrap: nowrap;
    gap: 8px;
    overflow-x: auto;
}
.info-modal-tabs .nav-link {
    border: 1px solid transparent;
    border-bottom: none;
    border-radius: 6px 6px 0 0;
    color: #55606e;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
    white-space: nowrap;
}
.info-modal-tabs .nav-link:hover {
    background: #eef2f7;
    color: #395272;
}
.info-modal-tabs .nav-link.active {
    background: #fff;
    color: #395272;
    border-color: #dee2e6 #dee2e6 #fff;
}
.info-modal-body {
    padding: 0;
    overflow: hidden;
    flex: 1 1 auto;
    min-height: 0;
}
.info-modal-content {
    overflow-y: auto;
    padding: 18px 24px 24px 24px;
    min-height: 260px;
    max-height: calc(88vh - 120px);
}
.info-modal-content ul {
    padding-left: 20px;
    margin-bottom: 12px;
}
.info-modal-content ul li {
    margin-bottom: 6px;
    line-height: 20px;
    text-align: justify;
}
.info-modal-content ul ul {
    margin-top: 6px;
    margin-bottom: 4px;
    list-style-type: circle;
    padding-left: 20px;
}
.info-modal-content ul ul li {
    margin-bottom: 4px;
}
.info-modal-figure {
    margin-top: 14px;
    text-align: center;
}
.info-modal-figure img {
    display: inline-block;
    max-width: 100%;
    height: auto;
    border: 1px solid #e3e8ee;
    border-radius: 6px;
}
.info-modal-note {
    margin: 8px 0 4px 0;
    padding: 8px 12px;
    background: #f4f8fb;
    border-left: 3px solid #395272;
    border-radius: 4px;
    font-size: 12.5px;
    line-height: 19px;
    text-align: justify;
    color: #445060;
}

.info-modal-tabs .nav-item {
    flex: 0 0 auto;
}
.info-modal-tabs .nav-link {
    background: transparent;
}
.info-modal-tabs .nav-link.active {
    background: #fff;
}
        .select-input {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px 10px;
            background: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .select-input input {
            border: none;
            width: 100%;
            cursor: pointer;
            background: transparent;
            outline: none;
        }

        .select-dropdown {
            display: none;
            position: absolute;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 3px;
            z-index: 9999;
            max-height: 250px;
            overflow: hidden;
        }

        .select-dropdown.show {
            display: block;
        }

        .dropdown-search {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 8px;
            outline: none;
        }

        #provinceList {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 180px;
            overflow-y: auto;
        }

        #provinceList li {
            padding: 5px 10px;
        }

        #provinceList li:hover {
            background: #f5f5f5;
        }

        #provinceList label {
            width: 100%;
            margin: 0;
            cursor: pointer;
        }

        /* ===== Google Places Autocomplete Fix ===== */
        .pac-container {
            z-index: 99999 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
            font-family: inherit !important;
            margin-top: 2px !important;
            border: 1px solid #ddd !important;
        }

        .pac-item {
            padding: 6px 12px !important;
            cursor: pointer !important;
            font-size: 13px !important;
            border-top: 1px solid #f0f0f0 !important;
        }

        .pac-item:hover {
            background: #f0f6ff !important;
        }

        .pac-item-query {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #333 !important;
        }

        .pac-matched {
            color: #1a73e8 !important;
            font-weight: 700 !important;
        }

        #locationSearchMap:focus {
            outline: none !important;
            border-color: #1a73e8 !important;
            box-shadow: 0 0 0 2px rgba(26,115,232,0.2) !important;
        }


#provinceSelect { position: relative; }
</style>
@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-end p-3" style="background-color: #dfeaf1;">

        <div class="d-flex gap-2 mt-2">

            <a href="{{ url('home') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
             <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                <small>Embassies</small>
            </a>

        </div>
    </div>

    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center gap-3 my-2">

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-link p-0 fw-bold text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#disclaimerModal">
                <i class="bi bi-info-circle text-primary fs-5"></i>
                Disclaimer
            </button>
        </div>

        <div class="d-flex align-items-end gap-3">
            <div style="margin-right:20px;">
                <span class="fw-bold pb-2 d-inline-block">Classification:</span>
            </div>
            <!-- Classification -->
            <div class="text-end" style="min-width: 700px;">
                <div class="row">
                    <div class="col-3 text-center fw-bold advanced br">Advanced</div>
                    <div class="col-4 text-center fw-bold intermediete br">Intermediate</div>
                    <div class="col-5 text-center fw-bold basic">Basic</div>
                </div>

                <div class="row text-center">
                <!-- Advanced -->
                    <div class="col-3 text-danger br">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
                            <small>Primary</small>
                        </button>
                    </div>

                    <!-- Intermediete -->
                     <div class="col-4 text-primary br">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
                            <small>Secondary</small>
                        </button>
                    </div>

                    <!-- Basic -->
                   <div class="col-4 text-success">
                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
                            <small>Tertiary</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

</div>


<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Every attempt has been made to ensure the completeness and accuracy of the most updated information and data available. Clients are advised, however, that provided information, and data is subject to change.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="primaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="primaryPublicModalLabel">Primary Medical Facilities (Public)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Primary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="primary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#primary-public-overview" type="button" role="tab" aria-controls="primary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-role-tab" data-bs-toggle="tab" data-bs-target="#primary-public-role" type="button" role="tab" aria-controls="primary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#primary-public-clinical" type="button" role="tab" aria-controls="primary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="primary-public-government-tab" data-bs-toggle="tab" data-bs-target="#primary-public-government" type="button" role="tab" aria-controls="primary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="primary-public-government" role="tabpanel" aria-labelledby="primary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="primary-public-overview" role="tabpanel" aria-labelledby="primary-public-overview-tab" tabindex="0">
<p class="p-modal">Public polyclinics form Singapore&#x27;s government-operated primary-care network. They are a major first point of contact for common acute illness, chronic-disease management, prevention, vaccination, screening, maternal-child services, allied health, and care coordination. Singapore had 28 polyclinics at the end of February 2026, organised under the three public healthcare clusters.</p>
<p class="info-modal-note">Note: Primary care is a level of care, not a hospital class. Polyclinics are outpatient facilities and do not normally operate hospital inpatient wards, major operating theatres, or intensive-care units. Private general-practitioner clinics, CHAS clinics, Family Medicine Clinics, and Primary Care Networks are important parts of the national primary-care system but are not public polyclinics. Primary Medical Facilities include public polyclinics, GP clinics, Family Medicine Clinics, Primary Care Networks, and Community Health Centers. They provide first-contact outpatient care, preventive services, screening, vaccination, chronic-disease management, minor treatment, diagnostics, and referrals.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="primary-public-role" role="tabpanel" aria-labelledby="primary-public-role-tab" tabindex="0">
<ul>
<li>Provide first-contact assessment and treatment for common acute and uncomplicated conditions</li>
<li>Manage diabetes, hypertension, hyperlipidaemia, and other chronic conditions, including Healthier SG follow-up</li>
<li>Deliver prevention, screening, vaccination, childhood development, maternal-child, and health-education services</li>
<li>Coordinate medication management, allied-health care, and referrals</li>
<li>Direct emergency or unstable patients to an emergency department or urgent-care service</li>
<li>Refer patients requiring specialist assessment, advanced diagnostics, surgery, or hospital admission</li>
</ul>
</div>
<div class="tab-pane fade" id="primary-public-clinical" role="tabpanel" aria-labelledby="primary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: No regular inpatient hospital beds</h6>
<h6 class="font-weight-bold mt-3">Core Services</h6>
<ul>
<li>General medical consultation and treatment of mild acute illness</li>
<li>Chronic-disease management, medication review, and long-term monitoring</li>
<li>Childhood immunisation, growth monitoring, and developmental assessment</li>
<li>Adult vaccination, preventive screening, and health counselling</li>
<li>Women&#x27;s health, maternal-child, mental-health, and geriatric services at designated sites</li>
<li>Dental, pharmacy, diagnostic, rehabilitation, dietetic, psychology, and other allied-health services according to site</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Wound care, dressing, injections, specimen collection, electrocardiography, and basic outpatient procedures</li>
<li>Minor procedures and treatment according to staff, equipment, licence, and site capability</li>
<li>No major surgery, intensive care, or full inpatient function</li>
<li>Immediate assessment, stabilisation, and transfer for severe illness, major trauma, obstetric emergency, or other hospital-level conditions</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Consultation, treatment, vaccination, screening, and chronic-care areas</li>
<li>Pharmacy and medication-dispensing services</li>
<li>Phlebotomy, basic laboratory testing, and diagnostic services according to site</li>
<li>Dental, radiology, rehabilitation, and allied-health services at designated polyclinics</li>
<li>Electronic records, HealthHub services, and referral links with public hospitals and specialty centers</li>
</ul>
<p class="info-modal-note">Note: The 28-polyclinic count is current to the end of February 2026. The Ministry of Health plans to expand the network to 32 polyclinics by 2030. Facility availability and service packages may change as new polyclinics open and existing sites are redeveloped.</p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="secondaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="secondaryPublicModalLabel">Secondary Medical Facilities (Public)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Secondary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="secondary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-overview" type="button" role="tab" aria-controls="secondary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-role-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-role" type="button" role="tab" aria-controls="secondary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-clinical" type="button" role="tab" aria-controls="secondary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="secondary-public-government-tab" data-bs-toggle="tab" data-bs-target="#secondary-public-government" type="button" role="tab" aria-controls="secondary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="secondary-public-government" role="tabpanel" aria-labelledby="secondary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="secondary-public-overview" role="tabpanel" aria-labelledby="secondary-public-overview-tab" tabindex="0">
<p class="p-modal">Secondary medical facilities are public regional and general hospitals that provide hospital-level emergency, inpatient, surgical, medical, diagnostic, and specialist care beyond primary-care capability. They manage common and moderately complex conditions, serve defined population catchments, stabilise critically ill patients, and refer highly complex or national-subspecialty cases to a tertiary hospital or national specialty center.</p>
<p class="info-modal-note">Note: The Ministry of Health commonly distinguishes central tertiary hospitals from regional hospitals, but it does not publish a universal statutory list grading every public hospital as secondary or tertiary. The secondary grouping below is a functional classification of the remaining public acute general hospitals. Secondary Medical Facilities consist mainly of regional and general acute hospitals providing emergency care, inpatient treatment, general medicine, surgery, intensive care, diagnostics, and specialist outpatient services. Examples include Alexandra Hospital, Ng Teng Fong General Hospital, Khoo Teck Puat Hospital, Sengkang General Hospital, and Woodlands Hospital.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="secondary-public-role" role="tabpanel" aria-labelledby="secondary-public-role-tab" tabindex="0">
<ul>
<li>The principal general hospital for a regional population catchment</li>
<li>Receive patients from polyclinics, general practitioners, ambulance services, urgent-care services, and direct emergency presentation</li>
<li>Manage common and moderately complex medical, surgical, orthopaedic, geriatric, and emergency conditions</li>
<li>Provide admission, observation, specialist outpatient care, diagnostic services, day treatment, and rehabilitation coordination</li>
<li>Stabilise critical or highly complex patients before tertiary transfer</li>
<li>Receive patients returned from tertiary care and coordinate continued management with primary and community services</li>
</ul>
</div>
<div class="tab-pane fade" id="secondary-public-clinical" role="tabpanel" aria-labelledby="secondary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: Approximately 300 – 1000 beds</h6>
<p class="info-modal-note">Note: Bed capacity does not independently determine whether a hospital functions at secondary or tertiary level.</p>
<h6 class="font-weight-bold mt-3">Core Specialties</h6>
<ul>
<li>General and acute internal medicine</li>
<li>General surgery and selected surgical subspecialties</li>
<li>Emergency medicine and acute assessment, except where an alternative urgent-care model applies</li>
<li>Orthopaedics, geriatrics, anaesthesia, radiology, pathology, pharmacy, and rehabilitation</li>
<li>Cardiology, neurology, renal medicine, respiratory medicine, gastroenterology, infectious diseases, psychiatry, and other specialties according to institution</li>
<li>Obstetric, gynaecological, paediatric, or other services where provided by the institution or through referral arrangements</li>
</ul>
<h6 class="font-weight-bold mt-3">Intermediate Services</h6>
<ul>
<li>Twenty-four-hour emergency assessment, inpatient care, and stabilisation at general hospitals with emergency departments</li>
<li>Specialist outpatient clinics, day treatment, ambulatory procedures, and pre-admission services</li>
<li>Intensive care, high-dependency care, peri-operative care, and short-stay treatment according to hospital capability</li>
<li>Hospital-at-home, transitional-care, rehabilitation, medical social work, pharmacy, and allied-health services</li>
<li>Clinical coordination with tertiary hospitals, national specialty centers, community hospitals, and primary care</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Common elective and emergency surgery within the hospital&#x27;s approved capability</li>
<li>General, orthopaedic, urological, vascular, endoscopic, minimally invasive, and other procedures according to institution</li>
<li>Anaesthesia, operating-theatre, recovery, and post-operative monitoring</li>
<li>Day surgery, interventional procedures, and short-stay treatment</li>
<li>Stabilisation and transfer of cases requiring national-subspecialty surgery, highly complex intervention, transplantation, or prolonged tertiary intensive care</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Hospital laboratory, pathology, blood-bank, and transfusion support</li>
<li>General and advanced radiology, CT, MRI, ultrasound, endoscopy, and other diagnostics according to institution</li>
<li>Emergency, ward, theatre, recovery, critical-care, pharmacy, and infection-control infrastructure</li>
<li>Physiotherapy, occupational therapy, speech therapy, dietetics, psychology, and medical social-work services</li>
<li>Integrated electronic records and referral communication across the public healthcare cluster</li>
</ul>
<p class="info-modal-note">Note: Community Hospitals</p>
<p class="p-modal">Community hospitals are intermediate inpatient facilities that provide post-acute, subacute, convalescent, and rehabilitative care after stabilisation at an acute hospital. They support recovery and transition to home, residential care, or long-term services. They should not be treated as a fourth level beside primary, secondary, and tertiary care, and they are not equivalent to secondary acute hospitals.</p>
<h6 class="font-weight-bold mt-3">Public Community Hospitals / Services</h6>
<ul>
<li>Bright Vision Hospital - SingHealth</li>
<li>Jurong Community Hospital - National University Health System</li>
<li>Yishun Community Hospital - NHG Health</li>
<li>Sengkang Community Hospital - SingHealth Community Hospitals</li>
<li>Outram Community Hospital - SingHealth Community Hospitals</li>
<li>Woodlands Hospital community-hospital service - NHG Health</li>
</ul>
<h6 class="font-weight-bold mt-3">Government-Funded Not-for-Profit Community Hospitals</h6>
<ul>
<li>Ang Mo Kio - Thye Hua Kwan Hospital</li>
<li>Ren Ci Community Hospital</li>
<li>St Andrew&#x27;s Community Hospital</li>
<li>St Luke&#x27;s Hospital</li>
</ul>
<p class="p-modal">Community hospitals are licensed under Community Hospital Service and normally receive medically stable patients from acute hospitals. They do not usually provide major emergency surgery or full acute-hospital capability.</p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="tertiaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="tertiaryPublicModalLabel">Tertiary Medical Facilities (Public)</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<ul class="nav nav-tabs info-modal-tabs px-3 pt-2" role="tablist" aria-label="Tertiary medical facility information">
<li class="nav-item" role="presentation"><button class="nav-link active" id="tertiary-public-overview-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-overview" type="button" role="tab" aria-controls="tertiary-public-overview" aria-selected="true">Overview</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-role-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-role" type="button" role="tab" aria-controls="tertiary-public-role" aria-selected="false">Role</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-clinical-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-clinical" type="button" role="tab" aria-controls="tertiary-public-clinical" aria-selected="false">Clinical Services</button></li>
<li class="nav-item" role="presentation"><button class="nav-link" id="tertiary-public-government-tab" data-bs-toggle="tab" data-bs-target="#tertiary-public-government" type="button" role="tab" aria-controls="tertiary-public-government" aria-selected="false">Government Healthcare System</button></li>
</ul>
<div class="modal-body info-modal-body">
<div class="tab-content info-modal-content">
<div class="tab-pane fade" id="tertiary-public-government" role="tabpanel" aria-labelledby="tertiary-public-government-tab" tabindex="0">
<p class="p-modal">Singapore operates a mixed public-private healthcare system under national regulation and government stewardship. The Ministry of Health sets policy, regulates healthcare services, plans capacity, administers subsidies and financing schemes, and oversees the public healthcare system. Public services are managed through three integrated clusters: National University Health System, NHG Health, and SingHealth. Each cluster links primary, secondary, tertiary, intermediate, community, and long-term care. [4][20]</p>
<p class="p-modal">For clinical and referral analysis, Singapore can be described through three principal levels: primary care, secondary care, and tertiary care. This three-level framework does not replace the Healthcare Services Act licensing framework, which licenses the service delivered rather than assigning a numerical or care-level grade to each institution.</p>
<h6 class="font-weight-bold mt-3">Key Facts</h6>
<ul>
<li><strong>System model:</strong> Mixed public-private healthcare with government regulation, public financing support, and public-cluster service delivery</li>
<li><strong>Lead authority:</strong> Ministry of Health, Singapore</li>
<li><strong>Principal care levels:</strong> Primary, secondary, and tertiary care</li>
<li><strong>Formal licensing framework:</strong> Service-based regulation under the Healthcare Services Act</li>
<li><strong>Public organisation:</strong> Three integrated clusters - National University Health System, NHG Health, and SingHealth</li>
<li><strong>Tertiary general hospitals:</strong> Singapore General Hospital, Tan Tock Seng Hospital, and National University Hospital</li>
<li><strong>Specialist tertiary hospitals:</strong> KK Women&#x27;s and Children&#x27;s Hospital and the Institute of Mental Health</li>
<li><strong>Secondary / regional general hospitals:</strong> Changi General Hospital, Khoo Teck Puat Hospital, Ng Teng Fong General Hospital, Sengkang General Hospital, Woodlands Hospital, and Alexandra Hospital</li>
<li><strong>Public primary care:</strong> 28 polyclinics as at the end of February 2026</li>
<li><strong>Intermediate inpatient care:</strong> Community hospitals provide post-acute, subacute, convalescent, and rehabilitative services outside the three principal acute-care levels</li>
<li><strong>Financing framework:</strong> Government subsidies, MediSave, MediShield Life, and MediFund</li>
<li><strong>Emergency medical access:</strong> SCDF 24-hour Emergency Medical Services through 995 for life-threatening emergencies</li>
<li><strong>Digital health:</strong> HealthHub and the National Electronic Health Record support access and care coordination</li>
</ul>
</div>
<div class="tab-pane fade show active" id="tertiary-public-overview" role="tabpanel" aria-labelledby="tertiary-public-overview-tab" tabindex="0">
<p class="p-modal">Tertiary medical facilities form Singapore&#x27;s highest clinical referral level. They manage complex, severe, high-risk, rare, and subspecialty conditions that require advanced multidisciplinary care, specialised technology, intensive support, or national expertise. Singapore&#x27;s tertiary network comprises major tertiary general hospitals, dedicated tertiary specialist hospitals, and national specialty centers.</p>
<p class="info-modal-note">Note: Singapore does not operate a statutory hospital grading system that licenses institutions as Primary, Secondary, or Tertiary hospitals. The Healthcare Services Act applies service-based licences, including Acute Hospital Service, Community Hospital Service, and Outpatient Medical Service. Tertiary Medical Facilities include major referral hospitals, university hospitals, specialist hospitals, and national specialty centers providing complex, subspecialist, critical-care, teaching, research, and national referral services. Examples include Singapore General Hospital, National University Hospital, Tan Tock Seng Hospital, KK Women’s and Children’s Hospital, the Institute of Mental Health, and the national cancer, heart, neuroscience, eye, dental, skin, and infectious-disease centers.</p>
<div class="info-modal-note"><strong>Disclaimer</strong>
<p class="p-modal">The medical facility classifications in this document organize Singapore’s medical facilities according to the facility types identified by the Ministry of Health, their clinical capability, referral role, and position in the patient-care pathway.</p>
<p><a href="https://www.moh.gov.sg/seeking-healthcare/getting-medical-help/" target="_blank" rel="noopener noreferrer">Singapore Ministry of Health</a></p></div>
</div>
<div class="tab-pane fade" id="tertiary-public-role" role="tabpanel" aria-labelledby="tertiary-public-role-tab" tabindex="0">
<ul>
<li>The national or major referral level for complex, severe, rare, and high-risk cases</li>
<li>Receive referrals from regional general hospitals, specialist clinics, polyclinics, general practitioners, emergency services, and other healthcare institutions</li>
<li>Provide advanced medical, surgical, psychiatric, obstetric, paediatric, diagnostic, intensive-care, and subspecialty services</li>
<li>Coordinate multidisciplinary treatment involving multiple specialties, national centers, rehabilitation, and long-term follow-up</li>
<li>Support undergraduate, postgraduate, nursing, allied-health, specialist, and subspecialist training</li>
<li>Lead clinical research, national programmes, professional standards, and advanced service development</li>
</ul>
</div>
<div class="tab-pane fade" id="tertiary-public-clinical" role="tabpanel" aria-labelledby="tertiary-public-clinical-tab" tabindex="0">
<h6 class="font-weight-bold mt-3">Bed Capacity: Approximately above 850 beds</h6>
<p class="info-modal-note">Note: Bed capacity does not independently determine whether a hospital functions at secondary or tertiary level.</p>
<h6 class="font-weight-bold mt-3">Main Public Tertiary General Hospitals</h6>
<ul>
<li>Singapore General Hospital (SGH) - SingHealth; Singapore&#x27;s largest acute tertiary hospital</li>
<li>Tan Tock Seng Hospital (TTSH) - NHG Health; identified by the Ministry of Health as a central tertiary hospital</li>
<li>National University Hospital (NUH) - National University Health System; university hospital and major tertiary referral institution</li>
</ul>
<h6 class="font-weight-bold mt-3">Specialist Tertiary Hospitals</h6>
<ul>
<li>KK Women&#x27;s and Children&#x27;s Hospital (KKH) - SingHealth; tertiary referral care for high-risk women and children</li>
<li>Institute of Mental Health (IMH) - NHG Health; Singapore&#x27;s national acute tertiary psychiatric hospital</li>
</ul>
<h6 class="font-weight-bold mt-3">National Specialty Centers</h6>
<ul>
<li>National Cancer Center Singapore (NCCS) - SingHealth</li>
<li>National University Cancer Institute, Singapore (NCIS) - National University Health System</li>
<li>National Heart Center Singapore (NHCS) - SingHealth</li>
<li>National University Heart Center, Singapore (NUHCS) - National University Health System</li>
<li>Singapore National Eye Center (SNEC) - SingHealth</li>
<li>National Skin Center (NSC) - NHG Health</li>
<li>National Neuroscience Institute (NNI) - SingHealth</li>
<li>National Center for Infectious Diseases (NCID) - NHG Health</li>
<li>National Dental Center Singapore (NDCS) - SingHealth</li>
<li>National University Center for Oral Health Singapore (NUCOHS) - National University Health System</li>
</ul>
<h6 class="font-weight-bold mt-3">Core Specialties</h6>
<ul>
<li>Advanced internal medicine and medical subspecialties</li>
<li>Complex general surgery and surgical subspecialties</li>
<li>Cardiology, cardiothoracic surgery, oncology, neuroscience, neurosurgery, transplant medicine, and other high-complexity services</li>
<li>High-risk obstetrics, maternal-fetal medicine, neonatology, paediatric subspecialties, and specialised women&#x27;s health services</li>
<li>Tertiary psychiatric assessment, inpatient treatment, rehabilitation, addiction services, and national mental-health programmes</li>
<li>National specialist services for cancer, cardiac, eye, skin, neuroscience, infectious diseases, and oral healthcare</li>
</ul>
<h6 class="font-weight-bold mt-3">Intermediate Services</h6>
<ul>
<li>Twenty-four-hour emergency, inpatient, and critical-care services at tertiary hospitals according to institutional scope</li>
<li>Specialist and subspecialist outpatient clinics, day treatment, multidisciplinary case review, and long-term surveillance</li>
<li>Medical, surgical, coronary, neonatal, paediatric, neurological, psychiatric, and other intensive or high-dependency care</li>
<li>Pharmacy, blood services, medical social work, rehabilitation, psychology, dietetics, and specialist nursing support</li>
<li>National consultation, shared-care, outreach, and referral support for regional hospitals and primary care</li>
</ul>
<h6 class="font-weight-bold mt-3">Surgical &amp; Procedural Capacity</h6>
<ul>
<li>Major elective, emergency, complex, and subspecialty surgery</li>
<li>Advanced anaesthesia, peri-operative medicine, post-operative critical care, and multidisciplinary rehabilitation</li>
<li>Cardiac, neurological, transplant, cancer, paediatric, obstetric, orthopaedic, reconstructive, dental, and other specialist procedures according to institution</li>
<li>Minimally invasive surgery, robotic surgery, endoscopy, catheter-based intervention, interventional radiology, radiotherapy, and other advanced treatment</li>
<li>Access to host-hospital operating theatres and inpatient support for national specialty centers that do not operate a complete independent hospital platform</li>
</ul>
<h6 class="font-weight-bold mt-3">Diagnostic &amp; Support Infrastructure</h6>
<ul>
<li>Advanced radiology and imaging, including CT, MRI, ultrasound, fluoroscopy, nuclear medicine, and interventional imaging according to institution</li>
<li>Comprehensive clinical laboratory, pathology, microbiology, molecular testing, blood-bank, and transfusion support</li>
<li>Critical-care monitoring, ventilatory support, isolation capability, specialist procedural suites, and advanced life-support systems</li>
<li>Operating theatres, recovery areas, sterile-supply services, infection-prevention systems, pharmacy, and medication-management infrastructure</li>
<li>Clinical registries, research platforms, teaching facilities, multidisciplinary conference systems, and integrated electronic records</li>
</ul>
<p class="info-modal-note">Note: The Ministry of Health expressly identified TTSH, SGH, and NUH as central tertiary hospitals in a 2023 parliamentary response. KKH and IMH describe themselves as tertiary specialist referral institutions. National specialty centers are included under tertiary care because they provide national or highly specialised referral services, although they are not a separate hospital level.</p>
</div>
</div>
</div>
</div>
</div>
</div>

    <div id="map"></div>

</div>


@endsection

@push('service')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&libraries=places,geometry,drawing"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// === Inisialisasi Peta ===
const map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: 1.3544957452433934, lng: 103.81333631449832 },
    zoom: 11,
    mapTypeId: 'roadmap',
    mapTypeControl: true,
    fullscreenControl: true,
    streetViewControl: false
});

const infoWindow = new google.maps.InfoWindow();

// === Directions (in-map routing) ===
const directionsService  = new google.maps.DirectionsService();
const directionsRenderer = new google.maps.DirectionsRenderer({
    suppressMarkers: false,
    polylineOptions: { strokeColor: '#1a73e8', strokeWeight: 5, strokeOpacity: 0.85 }
});
directionsRenderer.setMap(map);

// "Clear Route" button
const clearRouteBtn = document.createElement('div');
clearRouteBtn.id = 'clearRouteBtn';
clearRouteBtn.innerHTML = '✕ Clear Route';
Object.assign(clearRouteBtn.style, {
    display: 'none',
    background: '#fff',
    border: '2px solid rgba(0,0,0,0.2)',
    borderRadius: '6px',
    padding: '6px 12px',
    fontSize: '13px',
    fontWeight: '600',
    cursor: 'pointer',
    margin: '10px',
    color: '#d32f2f',
    boxShadow: '0 2px 6px rgba(0,0,0,0.15)'
});
clearRouteBtn.title = 'Clear the current route';
clearRouteBtn.addEventListener('click', () => {
    directionsRenderer.setDirections({ routes: [] });
    clearRouteBtn.style.display = 'none';
    closeRoutePanel();
});
map.controls[google.maps.ControlPosition.TOP_CENTER].push(clearRouteBtn);

// Helper: close route panel
function closeRoutePanel() {
    const panel = document.getElementById('routePanel');
    if (panel) panel.style.display = 'none';
    directionsRenderer.setDirections({ routes: [] });
    clearRouteBtn.style.display = 'none';
}

// Helper: draw route on map + show panel
function showRouteOnMap(originLat, originLng, destLat, destLng, destName) {
    directionsService.route({
        origin: new google.maps.LatLng(originLat, originLng),
        destination: new google.maps.LatLng(destLat, destLng),
        travelMode: google.maps.TravelMode.DRIVING
    }, (result, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(result);
            clearRouteBtn.style.display = 'inline-block';
            infoWindow.close();

            const leg = result.routes[0].legs[0];
            const panel = document.getElementById('routePanel');
            document.getElementById('routePanelTitle').textContent = destName || 'Destination';
            document.getElementById('routeDistance').textContent  = leg.distance.text;
            document.getElementById('routeDuration').textContent  = leg.duration.text;

            const stepsEl = document.getElementById('routeSteps');
            stepsEl.innerHTML = leg.steps.map((step, i) => {
                const raw = (step.html_instructions || step.instructions || '');
                const instruction = raw.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                if (!instruction) return '';
                const icons = {
                    'Turn left':        '↰',
                    'Turn right':       '↱',
                    'Keep left':        '↖',
                    'Keep right':       '↗',
                    'Continue':         '↑',
                    'Head':             '↑',
                    'Roundabout':       '↻',
                    'U-turn':           '⟳',
                    'Merge':            '↑',
                    'Ramp':             '↗',
                    'Destination':      '📍',
                };
                let icon = '•';
                for (const [key, val] of Object.entries(icons)) {
                    if (instruction.startsWith(key)) { icon = val; break; }
                }
                const isLast = i === leg.steps.length - 1;
                return `
                    <div style="display:flex;gap:10px;padding:8px 14px;
                                border-bottom:${isLast ? 'none' : '1px solid #f0f0f0'};
                                align-items:flex-start;">
                        <div style="min-width:22px;height:22px;background:${isLast ? '#395272' : '#e8f0fe'};
                                    border-radius:50%;display:flex;align-items:center;
                                    justify-content:center;font-size:12px;
                                    color:${isLast ? '#fff' : '#1a73e8'};flex-shrink:0;margin-top:1px;">
                            ${icon}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:12px;color:#222;line-height:1.4;">${instruction}</div>
                            <div style="font-size:11px;color:#888;margin-top:2px;">${step.distance.text}</div>
                        </div>
                    </div>`;
            }).join('');

            panel.style.display = 'flex';
        } else {
            if (status === 'ZERO_RESULTS') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Route Not Found',
                    text: 'No driving route could be found between your location and the destination. The two locations may not be connected by road.',
                    confirmButtonColor: '#1a73e8',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Directions Error',
                    text: 'Could not get directions: ' + status,
                    confirmButtonColor: '#1a73e8',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}

// --- Nearby Category Bar (Google Maps style) — Hotels only ---
let categoryMarkers   = [];
let activeCategoryBtn = null;

const categoryBar = document.createElement('div');
categoryBar.id = 'nearbyCategBar';
Object.assign(categoryBar.style, {
    display:       'none',
    background:    'transparent',
    padding:       '8px 10px 0',
    gap:           '8px',
    flexWrap:      'nowrap',
    overflowX:     'auto',
    maxWidth:      '90vw',
    scrollbarWidth:'none'
});

const nearbyCategories = [
    { label: 'Hotels', icon: '🏨', type: 'lodging' }
];

nearbyCategories.forEach(cat => {
    const btn = document.createElement('button');
    btn.textContent = cat.icon + ' ' + cat.label;
    Object.assign(btn.style, {
        display:      'inline-flex',
        alignItems:   'center',
        gap:          '4px',
        padding:      '6px 14px',
        borderRadius: '20px',
        border:       '1px solid rgba(0,0,0,0.12)',
        background:   '#fff',
        color:        '#222',
        fontSize:     '13px',
        fontWeight:   '500',
        cursor:       'pointer',
        whiteSpace:   'nowrap',
        boxShadow:    '0 1px 4px rgba(0,0,0,0.15)',
        transition:   'all 0.15s'
    });

    btn.addEventListener('click', () => {
        if (activeCategoryBtn === btn) {
            clearCategoryMarkers();
            resetCategoryBtn(btn);
            activeCategoryBtn = null;
            return;
        }
        if (activeCategoryBtn) resetCategoryBtn(activeCategoryBtn);
        activeCategoryBtn = btn;
        btn.style.background = '#1a73e8';
        btn.style.color      = '#fff';
        btn.style.borderColor= '#1a73e8';
        showNearbyCategory(cat.type, cat.label);
    });

    categoryBar.appendChild(btn);
});

map.controls[google.maps.ControlPosition.TOP_CENTER].push(categoryBar);

function resetCategoryBtn(btn) {
    btn.style.background  = '#fff';
    btn.style.color       = '#222';
    btn.style.borderColor = 'rgba(0,0,0,0.12)';
}

function clearCategoryMarkers() {
    categoryMarkers.forEach(m => m.setMap(null));
    categoryMarkers = [];
}

function showNearbyCategory(type, label) {
    if (!lastClickedLocation) return;
    clearCategoryMarkers();

    const center  = new google.maps.LatLng(lastClickedLocation.lat, lastClickedLocation.lng);
    const service = new google.maps.places.PlacesService(map);

    const iconColors = { lodging: '#1a73e8' };
    const color = iconColors[type] || '#555';

    function makeSvgIcon(col) {
        const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='32' height='40' viewBox='0 0 32 40'>`
                  + `<path d='M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24S32 28 32 16C32 7.16 24.84 0 16 0z' fill='${col}'/>`
                  + `<circle cx='16' cy='16' r='7' fill='#fff'/>`
                  + `</svg>`;
        return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
    }

    service.nearbySearch({ location: center, radius: 5000, type }, (results, status) => {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
            if (status === 'ZERO_RESULTS') {
                alert(`No ${label.toLowerCase()} found within 5 km.`);
            } else {
                alert(`Failed to load ${label.toLowerCase()}. Error status: ${status}. Please ensure "Places API" is enabled and billing is active.`);
                console.error('PlacesService nearbySearch failed with status:', status);
            }
            return;
        }
        if (!results.length) return;

        results.forEach(place => {
            if (!place.geometry?.location) return;

            const marker = new google.maps.Marker({
                position: place.geometry.location,
                map,
                title: place.name,
                icon: { url: makeSvgIcon(color), scaledSize: new google.maps.Size(32, 40) },
                animation: google.maps.Animation.DROP
            });

            const dist     = google.maps.geometry.spherical.computeDistanceBetween(center, place.geometry.location);
            const distText = dist >= 1000 ? (dist / 1000).toFixed(1) + ' km' : Math.round(dist) + ' m';
            const rating   = place.rating ? `⭐ ${place.rating.toFixed(1)}` : '';
            const destLat  = place.geometry.location.lat();
            const destLng  = place.geometry.location.lng();
            const safeName = (place.name || '').replace(/'/g, "\\'");

            marker.addListener('click', () => {
                infoWindow.setContent(`
                    <div style="font-size:13px;min-width:190px;">
                        <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                        <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                        ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                        <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                        <div style="margin-top:8px;">
                            <button onclick="showRouteOnMap(${center.lat()},${center.lng()},${destLat},${destLng},'${safeName}')"
                                    style="display:inline-flex;align-items:center;gap:5px;
                                           background:#1a73e8;color:#fff;border:none;
                                           padding:5px 12px;border-radius:6px;font-size:12px;
                                           font-weight:500;cursor:pointer;">
                                <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                                </svg>
                                Get Directions
                            </button>
                        </div>
                    </div>`);
                infoWindow.open(map, marker);
            });

            categoryMarkers.push(marker);
        });
    });
}

// === Variabel Global ===
let hospitalMarkers = [];
let radiusCircle = null;
let radiusPinMarker = null;
let lastClickedLocation = null;
let drawnPolygonGeoJSON = null;

// === Polygon Draw (Custom Point-by-Point) ===
let isDrawingPolygon = false;
let polygonLatLngs = [];
let activePolygon = null;
let activePolyline = null;
let cursorPolyline = null;
let startMarker = null;

const drawButton = document.createElement('div');
drawButton.innerHTML = '⬟';
Object.assign(drawButton.style, {
    backgroundColor: 'white', border: '2px solid rgba(0,0,0,0.2)', borderRadius: '4px',
    width: '34px', height: '34px', textAlign: 'center', lineHeight: '30px',
    fontSize: '18px', cursor: 'pointer', margin: '10px'
});
drawButton.title = 'Draw Polygon (Click point by point, click starting point to finish)';
map.controls[google.maps.ControlPosition.LEFT_TOP].push(drawButton);

const clearButton = document.createElement('div');
clearButton.innerHTML = '🗑️';
Object.assign(clearButton.style, {
    backgroundColor: 'white', border: '2px solid rgba(0,0,0,0.2)', borderRadius: '4px',
    width: '34px', height: '34px', textAlign: 'center', lineHeight: '30px',
    fontSize: '16px', cursor: 'pointer', margin: '10px 0'
});
clearButton.title = 'Clear Polygon';
map.controls[google.maps.ControlPosition.LEFT_TOP].push(clearButton);

drawButton.addEventListener('click', () => {
    isDrawingPolygon = !isDrawingPolygon;
    if (isDrawingPolygon) {
        map.setOptions({ draggable: false });
        drawButton.style.backgroundColor = '#ccc';
        map.getDiv().style.cursor = 'crosshair';
        polygonLatLngs = [];
        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = new google.maps.Polyline({
            path: polygonLatLngs, strokeColor: '#ff6600', strokeOpacity: 0.8, strokeWeight: 3, clickable: false, map
        });
        cursorPolyline = new google.maps.Polyline({
            path: [], strokeColor: '#ff6600', strokeOpacity: 0.5, strokeWeight: 3, clickable: false, map
        });
        startMarker = null;
        drawnPolygonGeoJSON = null;
    } else {
        finishPolygon();
    }
});

map.addListener('mousemove', (e) => {
    if (!isDrawingPolygon || polygonLatLngs.length === 0) return;
    const lastPoint = polygonLatLngs[polygonLatLngs.length - 1];
    cursorPolyline.setPath([lastPoint, e.latLng]);
});

map.addListener('rightclick', () => {
    if (isDrawingPolygon) finishPolygon();
});

async function finishPolygon() {
    if (!isDrawingPolygon) return;
    isDrawingPolygon = false;
    map.setOptions({ draggable: true });
    drawButton.style.backgroundColor = 'white';
    map.getDiv().style.cursor = '';
    if (cursorPolyline) cursorPolyline.setMap(null);
    if (startMarker) startMarker.setMap(null);

    if (polygonLatLngs.length > 2) {
        if (activePolyline) activePolyline.setMap(null);
        activePolygon = new google.maps.Polygon({
            paths: polygonLatLngs, strokeColor: '#ff6600', strokeOpacity: 0.8, strokeWeight: 3,
            fillColor: '#ff6600', fillOpacity: 0.2, editable: true, map
        });

        const coordinates = polygonLatLngs.map(p => [p.lng(), p.lat()]);
        coordinates.push([polygonLatLngs[0].lng(), polygonLatLngs[0].lat()]);

        drawnPolygonGeoJSON = {
            type: "Feature",
            geometry: { type: "Polygon", coordinates: [coordinates] },
            properties: {}
        };

        const updatePolygonFilter = async () => {
            if (!activePolygon) return;
            const path = activePolygon.getPath();
            if (path.getLength() > 2) {
                const newCoords = [];
                for (let i = 0; i < path.getLength(); i++) {
                    const xy = path.getAt(i);
                    newCoords.push([xy.lng(), xy.lat()]);
                }
                newCoords.push([path.getAt(0).lng(), path.getAt(0).lat()]);
                drawnPolygonGeoJSON.geometry.coordinates = [newCoords];
                await applyHospitalFilters();
            }
        };

        google.maps.event.addListener(activePolygon.getPath(), 'set_at', updatePolygonFilter);
        google.maps.event.addListener(activePolygon.getPath(), 'insert_at', updatePolygonFilter);
        google.maps.event.addListener(activePolygon.getPath(), 'remove_at', updatePolygonFilter);

        await applyHospitalFilters();
    } else {
        if (activePolyline) activePolyline.setMap(null);
        activePolyline = null;
        activePolygon = null;
        drawnPolygonGeoJSON = null;
    }
}

clearButton.addEventListener('click', async () => {
    if (activePolygon) activePolygon.setMap(null);
    if (activePolyline) activePolyline.setMap(null);
    if (cursorPolyline) cursorPolyline.setMap(null);
    if (startMarker) startMarker.setMap(null);
    activePolygon = null;
    activePolyline = null;
    cursorPolyline = null;
    startMarker = null;
    polygonLatLngs = [];
    drawnPolygonGeoJSON = null;
    isDrawingPolygon = false;
    map.setOptions({ draggable: true });
    drawButton.style.backgroundColor = 'white';
    map.getDiv().style.cursor = '';
    await applyHospitalFilters();
});

// === Radius Circle & Location Pin ===
function updateRadiusCircleAndPin(radius = 0) {
    if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }

    if (radius > 0 && lastClickedLocation) {
        radiusCircle = new google.maps.Circle({
            strokeColor: '#FF0000', strokeOpacity: 0.8, strokeWeight: 2,
            fillColor: '#FF0000', fillOpacity: 0.2,
            map, center: lastClickedLocation, radius: radius * 1000
        });
    }
}

function placeLocationPin(location, label) {
    if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
    radiusPinMarker = new google.maps.Marker({
        position: location,
        map,
        title: label || 'Selected Location',
        icon: {
            url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            scaledSize: new google.maps.Size(25, 41)
        },
        zIndex: 9999,
        animation: google.maps.Animation.DROP
    });
}

map.addListener('click', e => {
    if (isDrawingPolygon) {
        polygonLatLngs.push(e.latLng);
        activePolyline.setPath(polygonLatLngs);

        if (polygonLatLngs.length === 1) {
            startMarker = new google.maps.Marker({
                position: e.latLng,
                map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE, scale: 6,
                    fillColor: '#FFFFFF', fillOpacity: 1, strokeColor: '#ff6600', strokeWeight: 2
                },
                zIndex: 999
            });
            startMarker.addListener('click', () => {
                if (isDrawingPolygon) finishPolygon();
            });
        }
        return;
    }

    lastClickedLocation = { lat: e.latLng.lat(), lng: e.latLng.lng() };
    placeLocationPin(lastClickedLocation, 'Selected Location');
    const radius = parseInt(document.querySelector('#radiusRangeMap')?.value || 0);
    const radiusValEl = document.querySelector('#radiusValueMap');
    if (radiusValEl) radiusValEl.textContent = radius;
    updateRadiusCircleAndPin(radius);
    categoryBar.style.display = 'flex';
    applyHospitalFilters();
});

// === Fetch Data Hospital ===
async function fetchHospitalData(filters = {}) {
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([k, v]) => {
        if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
        else if (v !== '' && v != null) params.append(k, v);
    });
    if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));

    try {
        const res = await fetch(`/api/hospital?${params.toString()}`);
        return res.ok ? await res.json() : [];
    } catch (e) {
        console.error('Error fetching hospital data:', e);
        return [];
    }
}

// === Tambah Marker Hospital ===
function addHospitalMarkers(data) {
    hospitalMarkers.forEach(m => m.setMap(null));
    hospitalMarkers = [];

    const bounds = new google.maps.LatLngBounds();

    data.forEach(h => {
        if (!h.latitude || !h.longitude) return;

        const position = { lat: parseFloat(h.latitude), lng: parseFloat(h.longitude) };

        const marker = new google.maps.Marker({
            position,
            map,
            icon: {
                url: h.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
                scaledSize: new google.maps.Size(24, 24)
            }
        });

        const itemName  = h.name || 'N/A';
        const detailUrl = `/hospitals/${h.id}`;

        const popupContent = `
            <h5 style="border-bottom:1px solid #cccccc;"><a href="${detailUrl}" style="color:inherit;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1a73e8'" onmouseout="this.style.color='inherit'">${itemName}</a></h5>
            <strong>Global Classification:</strong> ${h.facility_category || 'N/A'}<br>
            <strong>Country Classification:</strong> ${h.facility_level || 'N/A'}<br>
            <strong>Address:</strong>
                ${h.address || 'N/A'}
                ${h.city ? ', ' + h.city : ''}
                ${h.provinces_region ? ', ' + h.provinces_region : ''}, Singapore <br>
        `;

        marker.addListener('click', () => {
            const destLat = parseFloat(h.latitude);
            const destLng = parseFloat(h.longitude);

            let directionsBtn = '';
            if (lastClickedLocation && !isNaN(destLat) && !isNaN(destLng)) {
                const oLat = lastClickedLocation.lat;
                const oLng = lastClickedLocation.lng;
                directionsBtn = `
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;display:flex;gap:6px;flex-wrap:wrap;">
                        <button onclick="showRouteOnMap(${oLat},${oLng},${destLat},${destLng},'${(itemName||'').replace(/'/g,"\\'")}')"
                           style="display:inline-flex;align-items:center;gap:5px;
                                  background:#1a73e8;color:#fff;border:none;
                                  padding:5px 12px;border-radius:6px;font-size:12px;
                                  font-weight:500;cursor:pointer;">
                            <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                <polygon points='3 11 22 2 13 21 11 13 3 11'/>
                            </svg>
                            Get Directions
                        </button>
                        <a href="${detailUrl}"
                           style="display:inline-flex;align-items:center;gap:5px;
                                  background:#395272;color:#fff;text-decoration:none;
                                  padding:5px 12px;border-radius:6px;font-size:12px;
                                  font-weight:500;"
                           onmouseover="this.style.background='#5686c3'"
                           onmouseout="this.style.background='#395272'">
                            <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                            </svg>
                            Read More
                        </a>
                    </div>`;
            } else {
                directionsBtn = `
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #eee;">
                        <a href="${detailUrl}"
                           style="display:inline-flex;align-items:center;gap:5px;
                                  background:#395272;color:#fff;text-decoration:none;
                                  padding:5px 12px;border-radius:6px;font-size:12px;
                                  font-weight:500;"
                           onmouseover="this.style.background='#5686c3'"
                           onmouseout="this.style.background='#395272'">
                            <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                                <circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='12'/><line x1='12' y1='16' x2='12.01' y2='16'/>
                            </svg>
                            Read More
                        </a>
                    </div>`;
            }

            infoWindow.setContent(`<div style="font-size:13px; min-width: 200px;">${popupContent}${directionsBtn}</div>`);
            infoWindow.open(map, marker);
        });

        hospitalMarkers.push(marker);
        bounds.extend(position);
    });

    if (hospitalMarkers.length > 0)
        map.fitBounds(bounds, 50);
}

// === Apply Filter ===
let filterRequestVersion = 0;
async function applyHospitalFilters() {
    const requestVersion = ++filterRequestVersion;
    const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
    const levels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
    const hospitalSelect = $('#hospital_name_map').val() || '';
    const hospitalName = Array.isArray(hospitalSelect) ? hospitalSelect[0] : hospitalSelect;
    const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);

    let filters = {};
    if (hospitalName) filters.name = hospitalName;
    if (provs.length > 0) filters.provinces = provs;
    if (radius > 0 && lastClickedLocation) {
        filters.radius = radius;
        filters.center_lat = lastClickedLocation.lat;
        filters.center_lng = lastClickedLocation.lng;
    }

    const result = await fetchHospitalData(filters);
    if (requestVersion !== filterRequestVersion) return;

    const hospitals = Array.isArray(result) ? result : (result.hospitals || []);
    const levelCounts = { Tertiary: 0, Secondary: 0, Primary: 0 };
    hospitals.forEach(h => {
        const levels = (h.facility_level || '').split(',').map(level => level.trim().toLowerCase());
        Object.keys(levelCounts).forEach(level => {
            if (levels.includes(level.toLowerCase())) levelCounts[level]++;
        });
    });

    const filteredHospitals = hospitals.filter(h => {
        if (levels.length === 0) return true;
        if (!h.facility_level) return false;
        const dbLevels = h.facility_level.split(',').map(c => c.trim().toLowerCase());
        return levels.some(sel => dbLevels.includes(sel.toLowerCase()));
    });

    addHospitalMarkers(filteredHospitals);
    document.getElementById('totalCountDisplay').innerHTML = `<strong>Hospitals:</strong> ${filteredHospitals.length}`;

    Object.keys(levelCounts).forEach(level => {

        const id = level.replace(/\s+/g, '-');

        const el = document.getElementById(`count-${id}`);

        if (el) {
            el.textContent = levelCounts[level];
        }
    });
}

// === Filter Panel (Custom Google Maps Control) ===
const combinedPanelDiv = document.createElement('div');
combinedPanelDiv.id = 'combinedPanelDiv';
Object.assign(combinedPanelDiv.style, {
    background: 'white',
    borderRadius: '8px',
    boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
    minWidth: '260px',
    maxWidth: '290px',
    overflow: 'visible',
    margin: '10px'
});

combinedPanelDiv.innerHTML = `
    <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;border-radius:8px 8px 0 0;font-weight:600;letter-spacing:0.3px;">Filter &amp; Radius</button>

    <!-- Search Location - NOT inside scrollable div so dropdown is never clipped -->
    <div id="searchSection" style="padding:10px 10px 6px 10px;background:white;position:relative;">
        <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Search Location</strong>
        <div style="position:relative;margin-top:5px;">
            <input
                type="text"
                id="locationSearchMap"
                placeholder="Search Location..."
                autocomplete="off"
                style="width:100%;padding:7px 30px 7px 9px;border:1.5px solid #ddd;border-radius:6px;font-size:13px;box-sizing:border-box;"
            >
            <span id="locationSearchClear" title="Clear"
                style="position:absolute;right:8px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:15px;color:#aaa;display:none;">&times;</span>
        </div>
        <div id="locationFoundBadge" style="display:none;margin-top:6px;background:#e8f5e9;border:1px solid #a5d6a7;border-radius:5px;padding:4px 8px;font-size:12px;color:#2e7d32;">
            &#128204; <span id="locationFoundName"></span>
        </div>
    </div>

    <!-- Radius -->
    <div id="radiusSection" style="padding:0 10px 0 10px;">
        <hr style="margin:8px 0;">
        <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Radius: <span id="radiusValueMap">0</span> km</strong>
        <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin:4px 0;">
        <div style="display:flex;justify-content:space-between;font-size:11px;color:#888;margin-bottom:5px;">
            <span>0</span><span>250 km</span><span>500 km</span>
        </div>
        <div style="display:flex;gap:5px;margin-bottom:6px;">
            <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
            <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
        </div>
    </div>

    <!-- Scrollable filters -->
    <div id="filterPanel" style="padding:0 10px 10px 10px;max-height:52vh;overflow-y:auto;border-top:1px solid #eee;">
        <div style="padding-top:8px;">
            <label>Hospital Name:</label>
            <select id="hospital_name_map" class="form-select form-select-sm mb-2 select-search-hospital">
                <option value="">Select Hospital</option>
                @foreach($hospitalNames as $n)
                    <option value="{{ $n }}">{{ $n }}</option>
                @endforeach
            </select>
            <label>Facility Level:</label>
            ${['Tertiary','Secondary','Primary'].map(c => `
            <label style="display:block;font-size:13px;margin-bottom:5px;">
                <input type="checkbox" name="hospitalLevel" value="${c}">
                ${c} (<span id="count-${c.replace(/\s+/g,'-')}">0</span>)
            </label>
            `).join('')}
            <hr>
            <div class="filter-box" id="provinceSelect">
                <label class="filter-label">Province</label>

                <div class="select-input">
                    <input
                        type="text"
                        id="provinceSearch"
                        placeholder="Select Province"
                        readonly
                    >
                    <i class="bi bi-chevron-down"></i>
                </div>

                <div class="select-dropdown">
                    <input
                        type="text"
                        class="dropdown-search"
                        id="provinceSearchInput"
                        placeholder="Search Province..."
                    >

                    <ul id="provinceList">
                        @foreach ($provinces as $p)
                        <li>
                            <label>
                                <input
                                    type="checkbox"
                                    class="province-checkbox"
                                    value="{{ $p->id }}"
                                >
                                {{ $p->provinces_region }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <button id="resetMapFilter" class="btn btn-sm btn-secondary w-100">Reset All</button>
            <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
        </div>
    </div>`;

google.maps.event.addDomListener(combinedPanelDiv, 'click', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'dblclick', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'mousedown', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'touchstart', e => e.stopPropagation());
google.maps.event.addDomListener(combinedPanelDiv, 'wheel', e => e.stopPropagation());
map.controls[google.maps.ControlPosition.RIGHT_TOP].push(combinedPanelDiv);

// === Init Select2 (retry sampai panel benar-benar ada di DOM) ===
function initHospitalSelect2() {
    const el = document.getElementById('hospital_name_map');
    if (typeof $ === 'undefined' || !$.fn || !$.fn.select2 || !el) {
        setTimeout(initHospitalSelect2, 200);
        return;
    }
    if ($(el).hasClass('select2-hidden-accessible')) return;
    $(el).select2({
        width: '100%',
        placeholder: 'Search Hospital',
        allowClear: true
    });
}
initHospitalSelect2();

// Event select2 (delegated, jadi tidak tergantung timing DOM)
$(document).on('change', '#hospital_name_map', function() {
    applyHospitalFilters();
});

// === Init Location Search — Google Places Autocomplete ===
// .pac-container is repositioned to position:fixed via MutationObserver
// to bypass Google Maps container overflow:hidden clipping.
function initLocationSearch() {
    const input = document.getElementById('locationSearchMap');
    if (!input) {
        setTimeout(initLocationSearch, 300);
        return;
    }

    const clearBtn = document.getElementById('locationSearchClear');

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
        fields: ['geometry', 'name', 'formatted_address']
    });

    let pacContainer = null;

    function fixPacPosition() {
        if (!pacContainer) return;
        const rect = input.getBoundingClientRect();
        const styles = {
            position: 'fixed', zIndex: '2147483647',
            top: (rect.bottom + 2) + 'px', left: rect.left + 'px',
            width: rect.width + 'px', borderRadius: '0 0 8px 8px',
            boxShadow: '0 8px 24px rgba(0,0,0,0.2)', fontFamily: 'inherit'
        };
        Object.entries(styles).forEach(([key, value]) => {
            if (pacContainer.style[key] !== value) pacContainer.style[key] = value;
        });
    }

    const observer = new MutationObserver(() => {
        if (!pacContainer) {
            pacContainer = document.querySelector('.pac-container');
            if (pacContainer) {
                fixPacPosition();
                new MutationObserver(fixPacPosition).observe(
                    pacContainer, { attributes: true, attributeFilter: ['style'] }
                );
            }
        }
    });
    observer.observe(document.body, { childList: true, subtree: false });

    window.addEventListener('scroll', fixPacPosition, true);
    window.addEventListener('resize', fixPacPosition);
    input.addEventListener('focus',  fixPacPosition);
    input.addEventListener('input',  fixPacPosition);

    google.maps.event.addDomListener(input, 'keydown',   e => e.stopPropagation());
    google.maps.event.addDomListener(input, 'mousedown', e => e.stopPropagation());

    input.addEventListener('focus', () => {
        input.style.borderColor = '#1a73e8';
        input.style.boxShadow   = '0 0 0 3px rgba(26,115,232,0.15)';
    });
    input.addEventListener('blur', () => {
        input.style.borderColor = '#ddd';
        input.style.boxShadow   = 'none';
    });

    input.addEventListener('input', () => {
        if (clearBtn) clearBtn.style.display = input.value.length ? 'inline' : 'none';
    });

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;

        const loc = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        lastClickedLocation = loc;

        map.panTo(loc);
        map.setZoom(10);

        const label = place.name || place.formatted_address || 'Location';
        placeLocationPin(loc, label);

        if (clearBtn) clearBtn.style.display = 'inline';

        const badge     = document.getElementById('locationFoundBadge');
        const badgeName = document.getElementById('locationFoundName');
        if (badge)     badge.style.display = 'block';
        if (badgeName) badgeName.textContent = label;

        const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
        updateRadiusCircleAndPin(radius);
        categoryBar.style.display = 'flex';
        applyHospitalFilters();
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            input.value = '';
            clearBtn.style.display = 'none';
            if (pacContainer) pacContainer.style.display = 'none';

            const badge = document.getElementById('locationFoundBadge');
            if (badge) badge.style.display = 'none';

            if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
            if (radiusCircle)    { radiusCircle.setMap(null);    radiusCircle    = null; }
            lastClickedLocation = null;

            categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            const rEl    = document.getElementById('radiusRangeMap');
            const rValEl = document.getElementById('radiusValueMap');
            if (rEl)    rEl.value          = 0;
            if (rValEl) rValEl.textContent = '0';

            applyHospitalFilters();
            input.focus();
        });
    }
}

// === Events ===
document.addEventListener('input', e => {
    if (e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        document.getElementById('radiusValueMap').textContent = r;
        updateRadiusCircleAndPin(r);
    }
});

document.addEventListener('click', async e => {
    if (e.target.id === 'applyRadiusMap') {
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        if (radius > 0 && !lastClickedLocation) {
            alert('Cari lokasi terlebih dahulu menggunakan kolom "Search Location", atau klik langsung pada peta untuk menentukan titik radius.');
            return;
        }
        await applyHospitalFilters();
    }

    if (e.target.id === 'resetRadiusMap') {
        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        categoryBar.style.display = 'none';
        clearCategoryMarkers();
        if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

        await applyHospitalFilters();
    }

    if (e.target.id === 'resetMapFilter') {
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => cb.checked = false);
        if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
            $('.select-search-hospital').val(null).trigger('change');
        } else {
            document.getElementById('hospital_name_map').value = '';
        }

        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            provinceSearch.value = '';
            provinceSearch.placeholder = 'Select Province';
        }
        const provinceSearchInput = document.getElementById('provinceSearchInput');
        if (provinceSearchInput) provinceSearchInput.value = '';
        document.querySelectorAll('#provinceList li').forEach(li => { li.style.display = ''; });
        const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');
        if (provinceDropdown) provinceDropdown.classList.remove('show');

        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) { radiusCircle.setMap(null); radiusCircle = null; }
        if (radiusPinMarker) { radiusPinMarker.setMap(null); radiusPinMarker = null; }
        lastClickedLocation = null;

        const locInput = document.getElementById('locationSearchMap');
        const locClear = document.getElementById('locationSearchClear');
        const locBadge = document.getElementById('locationFoundBadge');
        if (locInput) locInput.value = '';
        if (locClear) locClear.style.display = 'none';
        if (locBadge) locBadge.style.display = 'none';

        categoryBar.style.display = 'none';
        clearCategoryMarkers();
        if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

        if (activePolygon) activePolygon.setMap(null);
        if (activePolyline) activePolyline.setMap(null);
        if (cursorPolyline) cursorPolyline.setMap(null);
        if (startMarker) startMarker.setMap(null);
        activePolygon = null;
        activePolyline = null;
        cursorPolyline = null;
        startMarker = null;
        polygonLatLngs = [];
        drawnPolygonGeoJSON = null;

        await applyHospitalFilters();
    }
}, true);

// === Checkbox & select change auto apply ===
document.addEventListener('change', e => {
    if (e.target.classList.contains('province-checkbox') || e.target.name === 'hospitalLevel') {
        applyHospitalFilters();
    }
});

// === Province: Select - Search Checkbox ===
document.addEventListener('click', (e) => {
    const provinceSelectInput = e.target.closest('#provinceSelect .select-input');
    const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');

    if (provinceSelectInput) {
        if (provinceDropdown) provinceDropdown.classList.toggle('show');
    } else {
        const provinceSelect = document.getElementById('provinceSelect');
        if (provinceSelect && !provinceSelect.contains(e.target) && provinceDropdown) {
            provinceDropdown.classList.remove('show');
        }
    }
}, true);

document.addEventListener('keyup', (e) => {
    if (e.target.id === 'provinceSearchInput') {
        const keyword = e.target.value.toLowerCase();
        document.querySelectorAll('#provinceList li').forEach(li => {
            const text = li.textContent.toLowerCase();
            li.style.display = text.includes(keyword) ? '' : 'none';
        });
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('province-checkbox')) {
        const selected = [...document.querySelectorAll('.province-checkbox:checked')]
            .map(cb => cb.parentElement.textContent.trim());
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            if (selected.length === 0) {
                provinceSearch.value = '';
                provinceSearch.placeholder = 'Select Province';
            } else if (selected.length <= 2) {
                provinceSearch.value = selected.join(', ');
            } else {
                provinceSearch.value = selected.length + ' Province Selected';
            }
        }
    }
});

// === Inisialisasi Awal ===
setTimeout(() => {
    initLocationSearch();
}, 350);

// Retry sampai badge kategori (di dalam combinedPanelDiv) benar-benar ada di DOM,
// supaya jumlah per kategori tidak "nyangkut" di 0 saat load pertama.
function initialApplyFilters() {
    if (!document.getElementById('count-Tertiary')) {
        setTimeout(initialApplyFilters, 200);
        return;
    }
    applyHospitalFilters();
}
initialApplyFilters();
</script>

@endpush
