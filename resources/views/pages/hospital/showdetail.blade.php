@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.css" />

<style>
    #map {
        height: 600px;
    }

    p{
        margin-bottom: 8px;
        line-height: 18px;
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

     .leaflet-routing-container-hide .leaflet-routing-collapse-btn
    {
        left: 8px;
        top: 8px;
    }

    .leaflet-control-container .leaflet-routing-container-hide {
        width: 48px;
        height: 48px;
    }
     /* Classification */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: center;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: center;}
    .class-airport-category {border: none;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .hospital-icon {
      width: 18px;
      height: 18px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Image inside icon box */
    .hospital-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Airfield icons */
    .category-item img {
      width: 16px;
      height: 16px;
      object-fit: contain;
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
</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">

        <div class="d-flex flex-column gap-1">
            <h2 class="fw-bold mb-0">{{ $hospital->name }}</h2>
            <span class="fw-bold"><b>Global Classification:</b> {{ $hospital->facility_category }} | <b>Country Classification:</b> {{ $hospital->facility_level }}</span>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-medical-facility-white.png') }}" style="width: 18px; height: 24px;">
                <small>Clinical</small>
            </a>

            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                <small>Air Charter</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
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

    <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated {{ $hospital->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('hospitaldata.edit', $hospital->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-general-info.png') }}" style="width: 24px; height: 24px;"> General Medical Facility Info</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Status:</strong> {{ $hospital->status }}
                    </p>
                    <p>
                        <strong>Number Of Beds:</strong> {{ $hospital->number_of_beds }}
                    </p>
                    <p>
                        <strong>Population Catchment:</strong> {{ $hospital->population_catchment }}
                    </p>
                    <p>
                        <strong>Ownership:</strong> {{ $hospital->ownership }}
                    </p>
                    <p>
                        <strong>Hours Of Operation:</strong><br>
                        <?php echo $hospital->hrs_of_operation; ?>
                    </p>
                    <p>
                        <strong>Note:</strong>
                        <?php echo $hospital->others; ?>
                    </p>
                    <p>
                        <strong>Medical Services Info:</strong> <?php echo $hospital->other_medical_info; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-location.png') }}" style="width: 18px; height: 24px;"> Location</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Address:</strong>
                        {{ $hospital->address }},
                        {{ $city->city }},
                        {{ $province->provinces_region }}, Singapore
                    </p>
                    <p>
                        <strong>Latitude:</strong> {{ $hospital->latitude }}
                    </p>
                    <p>
                        <strong>Longitude:</strong> {{ $hospital->longitude }}
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/contact-icon.png') }}" style="width: 24px; height: 24px;"> Contact Details</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Telephone:</strong> <?php echo $hospital->telephone; ?>
                    </p>
                    <p>
                        <strong>Fax:</strong> <?php echo $hospital->fax; ?>
                    </p>
                    <p>
                        <strong>Email:</strong> <?php echo $hospital->email; ?>
                    </p>
                    <p>
                        <strong>Website:</strong> <?php echo $hospital->website; ?>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-nearest-accomodation.png') }}" style="width: 24px; height: 18px;">  Nearest Accommodation</div>
                <div class="card-body overflow-auto">
                    <?php echo $hospital->nearest_accommodation; ?>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card">

             <div class="classification" style="flex-direction: column; width:100%;">
                      <div class="class-header class-medical-classification">Medical Facility Classification</div>
                      <div class="classification">
                        <!-- Advanced -->
                        <div class="class-column">
                          <div class="class-header class-advanced">Advanced</div>
                          <div class="hospital-list">
                            <div class="hospital-item">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                <small>Tertiary</small>
                              </button>
                            </div>
                          </div>
                        </div>

                        <!-- Intermediate -->
                        <div class="class-column">
                          <div class="class-header class-intermediate">Intermediate</div>
                          <div class="hospital-list">
                            <div class="hospital-row">
                              <div class="hospital-item">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                  <small>Secondary</small>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Basic -->
                        <div class="class-column">
                          <div class="class-header class-basic">Basic</div>
                          <div class="hospital-list">
                            <div class="hospital-row">
                              <div class="hospital-item">
                                <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                                  <small>Primary</small>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="primaryPublicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered info-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
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
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
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

@endsection

@push('service')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const latitude = {{ $hospital->latitude }};
    const longitude = {{ $hospital->longitude }};
    const embassyName = '{{ $hospital->name }}';

    const map = L.map('map', {
        fullscreenControl: true
    }).setView([latitude, longitude], 17);

    // --- Define Tile Layers ---
    // 1. Street Map (OpenStreetMap)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18 // OSM generally goes up to zoom level 22
    });

    // 2. Satellite Map (Esri World Imagery) - Recommended, no API key needed
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
        maxZoom: 18 // Esri World Imagery also typically goes up to zoom level 22
    });

    // Add the satellite layer to the map by default
    satelliteLayer.addTo(map);

    // --- Add Layer Control ---
    // Define the base layers that the user can switch between
   const baseLayers = {
        "Satelit Map": satelliteLayer,
        "Street Map": osmLayer
    };

    // Add the layer control to the map. This will appear in the top-right corner.
    L.control.layers(baseLayers).addTo(map);

    // Add a marker at the embassy's location
    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(embassyName) // Display the embassy's name when the marker is clicked
        .openPopup(); // Automatically open the popup when the map loads
</script>
@endpush
