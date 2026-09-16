@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Airports')

@push('styles')

<style>
    #map {
        height: 600px;
    }

    table {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td {
        border: 1px solid black;
        padding: 4px;
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

     /* Classification section */
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

    .legend-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        width: 100%;
        align-items: start;
    }

    .legend-grid-item {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 6px;
        width: 100%;
        text-align: left;
        white-space: nowrap;
    }

    .legend-grid-item img {
        flex-shrink: 0;
    }

    .legend-grid-item small {
        text-align: left;
    }

    /* ====== DIRECTIONS PANEL - Modern Styling ====== */
    #directionsPanel {
        font-family: 'Segoe UI', Roboto, -apple-system, sans-serif !important;
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 transparent;
    }
    #directionsPanel::-webkit-scrollbar { width: 5px; }
    #directionsPanel::-webkit-scrollbar-thumb {
        background: #c1c1c1; border-radius: 10px;
    }
    #directionsPanel .dp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: linear-gradient(135deg, #1a73e8, #4285f4);
        border-radius: 8px 8px 0 0;
        margin: 0;
        color: #fff;
    }
    #directionsPanel .dp-header-title {
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    #directionsPanel .dp-header-title i { color: #fff !important; font-size: 16px; }
    #directionsPanel .dp-close-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: #fff;
        width: 28px; height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: background 0.2s;
    }
    #directionsPanel .dp-close-btn:hover { background: rgba(255,255,255,0.35); }
    #directionsPanel .dp-close-btn i { color: #fff !important; }

    /* Google-generated table overrides */
    #directionsPanel table { border: none !important; width: 100%; }
    #directionsPanel td {
        border: none !important;
        padding: 6px 4px !important;
        font-size: 13px;
        vertical-align: top;
    }
    #directionsPanel .adp-directions { margin: 0 !important; }

    /* Route summary (origin → destination bar) */
    #directionsPanel .adp-placemark {
        background: #f0f4ff;
        border-radius: 8px;
        margin-bottom: 8px !important;
        overflow: hidden;
    }
    #directionsPanel .adp-placemark td {
        padding: 10px 12px !important;
        font-weight: 600;
        color: #1a3c6e;
        font-size: 13px;
    }
    #directionsPanel .adp-placemark img {
        filter: hue-rotate(200deg) saturate(1.5);
    }

    /* Summary bar (distance & time) */
    #directionsPanel .adp-summary {
        background: linear-gradient(135deg, #e8f0fe, #d2e3fc);
        border-radius: 8px;
        padding: 10px 14px !important;
        margin: 8px 0 !important;
        font-size: 13px;
        color: #1a3c6e;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Step list */
    #directionsPanel .adp-listsel,
    #directionsPanel .adp-list {
        border: none !important;
    }
    #directionsPanel .adp-listinfo {
        border: none !important;
        background: transparent !important;
    }

    /* Individual step rows */
    #directionsPanel .adp-step {
        border-bottom: 1px solid #eef1f5 !important;
        border-left: none !important;
        border-right: none !important;
        border-top: none !important;
        transition: background 0.15s;
        border-radius: 6px;
        margin-bottom: 2px;
    }
    #directionsPanel .adp-step:hover {
        background: #f5f8ff !important;
    }
    #directionsPanel .adp-step:last-child {
        border-bottom: none !important;
    }

    /* Step icon cell */
    #directionsPanel .adp-step .adp-stepicon {
        padding: 8px 4px 8px 8px !important;
    }
    #directionsPanel .adp-step .adp-stepicon .adp-maneuver {
        width: 20px;
        height: 20px;
    }

    /* Step text */
    #directionsPanel .adp-step .adp-substep {
        padding: 8px 12px 8px 4px !important;
        color: #333;
        line-height: 1.5;
        font-size: 12.5px;
    }
    #directionsPanel .adp-step .adp-substep b {
        color: #1a73e8;
        font-weight: 600;
    }
    /* Step distance */
    #directionsPanel .adp-step td:last-child {
        color: #5f6368;
        font-size: 12px;
        white-space: nowrap;
        padding-right: 10px !important;
    }

    /* Warning / legal */
    #directionsPanel .adp-warnbox,
    #directionsPanel .adp-legal {
        font-size: 11px;
        color: #888;
        padding: 6px 12px !important;
        border: none !important;
    }
    #directionsPanel .adp-legal a { color: #1a73e8; }

    /* Highlighted / selected step */
    #directionsPanel .adp-listsel {
        background: #e8f0fe !important;
        border-radius: 6px;
    }

    /* === Info modal bertab (Polda / Polres / Polsek) ===
       Sama seperti di halaman Police, Dashboard, Airports, & Hospital. Lebarnya
       cukup untuk satu baris tab, tingginya mengikuti isi. CSS halaman ini
       Bootstrap 4 (AdminLTE), jadi lebar dialog harus di-override sendiri. */
    .info-modal-dialog {
        max-width: 1180px;
        width: 95vw;
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
        gap: 2px;
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

    /* Tabel klasifikasi Polda (gaya biru bertingkat) */
    .polda-class-table {
        width: 100%;
        margin: 4px 0 8px 0;
        border-collapse: collapse;
        font-size: 13px;
        line-height: 19px;
        color: #10333f;
    }
    .polda-class-table th,
    .polda-class-table td {
        padding: 10px 12px;
        border: 1px solid #fff;
        text-align: justify;
        vertical-align: top;
    }
    .polda-class-table thead th {
        background: #1c7fa4;
        color: #fff;
        font-weight: 700;
        text-align: left;
        vertical-align: middle;
    }
    .polda-class-table tbody tr:nth-child(odd) td {
        background: #62c2dd;
    }
    .polda-class-table tbody tr:nth-child(even) td {
        background: #cbe7f4;
    }

    /* Tabel klasifikasi unit Polres & Polsek (kolom pertama navy, baris biru bertingkat) */
    .unit-class-table {
        width: 100%;
        margin: 4px 0 8px 0;
        border-collapse: collapse;
        font-size: 13px;
        line-height: 19px;
        color: #10333f;
    }
    .unit-class-table th,
    .unit-class-table td {
        padding: 10px 12px;
        border: 1px solid #fff;
        vertical-align: top;
    }
    .unit-class-table thead th {
        background: #14506a;
        color: #fff;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
    }
    .unit-class-table tbody th {
        background: #14506a;
        color: #fff;
        font-weight: 700;
        text-align: left;
    }
    .unit-class-table tbody tr:nth-child(odd) td {
        background: #83c9e5;
    }
    .unit-class-table tbody tr:nth-child(even) td {
        background: #cfe7f5;
    }
    .emergency-legend-row {
        display: flex;
        align-items: flex-start;
        gap: 24px;
        padding: 10px;
        overflow-x: auto;
    }
    .emergency-airfield-legend {
        flex: 0 0 350px;
        width: 350px;
    }
    .emergency-medical-legend {
        flex: 0 0 280px;
        width: 280px;
        flex-direction: column;
    }
    .emergency-legend-row .class-header,
    .police-classification-title {
        text-align: left;
        font-weight: 700;
        line-height: 20px;
    }
    .emergency-legend-row .class-airport-category,
    .emergency-legend-row .class-medical-classification,
    .police-classification-title {
        display: block;
        padding: 0;
        margin: 0 0 8px;
        text-transform: uppercase;
    }
    .emergency-legend-row .hospital-list,
    .emergency-legend-row .hospital-row {
        align-items: flex-start;
        justify-content: flex-start;
    }
    .emergency-airfield-legend .hospital-item {
        display: grid;
        grid-template-columns: 105px 90px 80px 75px;
    }
    .emergency-legend-row .btn {
        display: inline-flex;
        align-items: center;
        justify-content: flex-start;
        gap: 6px;
        text-align: left;
        padding: 4px 0 !important;
    }
    .emergency-medical-legend .class-column {
        min-width: 0;
    }
    .police-classification {
        flex: 0 0 auto;
        text-align: left;
    }
    .police-classification-grid {
        display: grid;
        grid-template-columns: max-content max-content;
        column-gap: 20px;
        row-gap: 4px;
    }
    .police-classification-grid .btn {
        white-space: nowrap;
        gap: 8px;
    }
    .police-classification-grid img {
        width: 12px;
        height: 12px;
        flex: 0 0 12px;
        object-fit: contain;
    }
    .police-classification-grid small {
        line-height: 18px;
    }
</style>

@endpush

@section('conten')

<div class="card">

<div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
       <div class="d-flex flex-column gap-1">
            <h2 class="fw-bold mb-0">{{ $embassy->name_embassiees }}</h2>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

              <!-- Button 2 -->
             <a href="{{ url('embassiees') }}/{{$embassy->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees/'.$embassy->id.'/detail') ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('embassiees') }}/{{$embassy->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees/'.$embassy->id.'/emergency') ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <!-- Button 6 -->
            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                <small>Air Charter</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

        </div>
</div>

   <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated {{ $embassy->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('embassiees.edit', $embassy->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

    <div class="row">

        <div class="col-sm-8 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-emergency-support.png') }}" style="width: 24px; height: 24px;"> Emergency Support Tools</div>

                    <!-- Legend container -->
                  <div class="emergency-legend-row">
                    <!-- Airfield Classification -->
                    <div class="classification emergency-airfield-legend">
                      <!-- Airport -->
                      <div class="class-column">
                        <div class="class-header class-airport-category">Airfield Classification</div>
                        <div class="hospital-list">
                          <div class="hospital-row" style="flex-direction: column;">
                            <!-- Airport row 1 -->
                            <div class="hospital-item">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:18px; height:18px;">
                                  <small>International</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level5Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:18px; height:18px;">
                                  <small>Domestic</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level4Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:18px; height:18px;">
                                  <small>Regional</small>
                              </button>
                            </div>
                            <!-- Airport row 2 -->
                            <div class="hospital-item">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                  <small>Civil-Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level3Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                  <small>Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                  <small>Private</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/11/helipad-removebg.png" style="width:18px; height:18px;">
                                  <small>Helipad</small>
                              </button>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <!-- Hospital Classification -->
                    <div class="classification emergency-medical-legend">
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

                    <div class="police-classification">
                        <span class="fw-bold police-classification-title">Police Classification</span>
                        <div class="police-classification-grid">

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#nationalPoliceHqModal">
                          <img src="{{ asset('images/Layer1.png') }}" style="width:12px; height:12px;">
                          <small>National Police (HQ)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#policeDivisionsModal">
                          <img src="{{ asset('images/Layer2.png') }}" style="width:12px; height:12px;">
                          <small>Police Divisions (Land Divisions)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#neighbourhoodPoliceCentreModal">
                          <img src="{{ asset('images/Layer3.png') }}" style="width:12px; height:12px;">
                          <small>Neighbourhood Police Centre (NPC)</small>
                        </button>

                        <button type="button" class="btn p-1" data-bs-toggle="modal" data-bs-target="#neighbourhoodPolicePostModal">
                          <img src="{{ asset('images/Layer4.png') }}" style="width:12px; height:12px;">
                          <small>Neighbourhood Police Post (NPP)</small>
                        </button>
                        </div>
                      </div>

                  </div>

                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="https://concord-consulting.com/static/img/cmt/icon/radar-icon.png" style="width: 24px; height: 24px;"> Nearest Support Facilities</div>
                <div class="card-body overflow-auto">
                    <?php echo $embassy->nearest_medical_facility; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/hotlines-icon.png') }}" style="width: 24px; height: 24px;"> Emergency Hotline</div>
                <div class="card-body">
                    <?php echo $hospital->travel_agent; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-medical-support-website.png') }}" style="width: 24px; height: 24px;"> Emergency Medical Support</div>
                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                        <?php echo $hospital->medical_support_website; ?>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="level1Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Private Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
        <p class="p-modal text-justify">Also known as private airfields or airstrips are primarily used for general and private aviation are owned by private individuals, groups, corporations, or organizations operated for their exclusive use that may include limited access for authorized personnel by the owner or manager. Owners are responsible to ensure safe operation, maintenance, repair, and control of who can use the facilities. Typically, they are not open to the public or provide scheduled commercial airline services and cater to private pilots, business aviation, and sometimes small charter operations. Services may be provided if authorized by the appropriate regulatory authority.</p>

        <p class="p-modal text-justify">A large majority of private airports are grass or dirt strip fields without services or facilities, they may feature amenities such as hangars, fueling facilities, maintenance services, and ground transportation options tailored to the needs of their owners or users. Private airports are not subject to the same level of regulatory oversight as public airports, but must still comply with applicable aviation regulations, safety standards, and environmental requirements. In the event of an emergency, landing at a private airport is authorized without any prior approval and should be done if landing anywhere else compromises the safety of the aircraft, crew, passengers, or cargo.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level2Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Combined (Civil-Military) Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">Also called "joint-use airport," are used by both civilian and military aircraft, where a formal agreement exists between the military and a local government agency allowing shared access to infrastructure and facilities, typically with separate passenger terminals and designated operating areas, airspace allocation, and aircraft scheduling. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level3Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
        <p class="p-modal text-justify">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level4Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Regional Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal text-justify">A small or remote regional domestic airfield usually located in a geographically isolated area, far from major population centers, often with difficult terrain or vast distances from other airports with limited passenger traffic. May have shorter runways, basic facilities, and limited amenities, and basic infrastructure, serving primarily local communities providing access to essential services like medical transport or regional travel, rather than large-scale commercial flights.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level5Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
        <p class="p-modal text-justify">Exclusively manages flights that originate and end within the same country, does not have international customs or border control facilities. Airport often has smaller and shorter runways, suitable for smaller regional aircraft used on domestic routes, and cannot support larger haul aircraft having less developed support services. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level6Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">International Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
        <p class="p-modal text-justify">Meet standards set by the International Air Transport Association (IATA) and the International Civil Aviation Organization (ICAO), facilitate transnational travel managing flights between countries, have customs and border control facilities to manage passengers and cargo, and may have dedicated terminals for domestic and international flights. International airports have longer runways to accommodate larger, heavier aircraft, are often a main hub for air traffic, and can serve as a base for larger airlines. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage</p>
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

<div class="modal fade" id="nationalPoliceHqModal" tabindex="-1" aria-labelledby="nationalPoliceHqModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer1.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="nationalPoliceHqModalLabel">National Police (HQ)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> National police commander</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Commissioner of Police (CP)</p>
        <p class="p-modal"><strong>Role:</strong> Highest commander of SPF</p>
        <p class="p-modal">The CP is the Chief Executive and professional head of the SPF. The Commissioner exercises overall command of the Force, provides strategic leadership, formulates policing policies, directs nationwide operations, and advises the Government and the Ministry of Home Affairs on policing and internal security matters.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise overall command and control of the SPF.</li>
          <li>Formulate strategic policing priorities aligned with national security objectives.</li>
          <li>Provide leadership for all operational, investigative, intelligence, administrative, and support functions.</li>
          <li>Advise the Minister for Home Affairs on policing, crime prevention, and public safety policies.</li>
          <li>Direct national responses to major criminal incidents, terrorism, civil emergencies, and public order events.</li>
          <li>Ensure effective coordination with other Home Team agencies and international law enforcement organizations.</li>
          <li>Oversee organizational governance, integrity, professional standards, and institutional accountability.</li>
          <li>Lead organizational modernization through technological innovation, digital transformation, and capability development.</li>
          <li>Represent the SPF in domestic, regional, and international policing forums.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="policeDivisionsModal" tabindex="-1" aria-labelledby="policeDivisionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer2.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="policeDivisionsModalLabel">Police Divisions (Land Divisions)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Top territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Assistant Commissioner of Police (AC Level)</p>
        <p class="p-modal">The <strong>Land Divisions</strong> represent the highest territorial command level within the SPF and serve as the principal operational formations responsible for delivering frontline policing services across Singapore. Each division is typically commanded by an <strong>Assistant Commissioner of Police (AC)</strong> and supervises a network of Neighborhood Police Centers and Neighborhood Police Posts that provide localized policing within residential, commercial, industrial, and civic communities. The seven (7) Land Divisions&mdash;<strong>Central (A), Clementi (D), Tanglin (E), Ang Mo Kio (F), Bedok (G), Jurong (J), and Woodlands (L)</strong>&mdash;are responsible for implementing national policing policies at the territorial level while maintaining close partnerships with local communities. Their responsibilities encompass patrol operations, criminal investigations, intelligence gathering, public safety, emergency management, crime prevention, and coordination with specialist police units during major incidents or security operations, thereby serving as the operational link between Police Headquarters and community-level policing.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise overall command and control of all policing operations within the assigned territorial division.</li>
          <li>Maintain public order, law enforcement, and public safety throughout the division.</li>
          <li>Supervise NPCs and NPPs.</li>
          <li>Direct crime prevention, patrol, emergency response, and criminal investigation activities.</li>
          <li>Coordinate responses to major incidents, disasters, and public security emergencies.</li>
          <li>Lead community policing initiatives and strengthen partnerships with residents, businesses, and community organizations.</li>
          <li>Oversee the deployment and management of personnel, operational resources, and policing assets.</li>
          <li>Monitor crime trends and implement intelligence-led policing strategies.</li>
          <li>Coordinate with specialist departments and Home Team agencies during joint operations.</li>
          <li>Ensure compliance with SPF operational policies, professional standards, and organizational directives.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="neighbourhoodPoliceCentreModal" tabindex="-1" aria-labelledby="neighbourhoodPoliceCentreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer3.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="neighbourhoodPoliceCentreModalLabel">Neighbourhood Police Centre (NPC)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Second-tier territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Superintendent of Police (SUPT) / Deputy Assistant Commissioner (DAC) Level</p>
        <p class="p-modal">The NPC is the second-tier territorial command within the SPF, operating under the supervision of a Land Division. Each NPC exercises operational control over several NPPs and patrol sectors within its assigned district, providing frontline policing, criminal investigations, emergency response, and community engagement. The NPC functions as the primary operational headquarters for coordinating local policing activities and implementing divisional policing strategies.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise command and control over all policing operations within the assigned district or NPC jurisdiction.</li>
          <li>Supervise NPPs, patrol officers, and response teams under the NPC.</li>
          <li>Coordinate emergency response, incident management, and frontline operational deployments.</li>
          <li>Direct investigations into criminal offenses occurring within the district and oversee case management.</li>
          <li>Implement crime prevention initiatives and community policing programs in collaboration with local stakeholders.</li>
          <li>Monitor local crime trends and develop targeted operational strategies to address emerging security concerns.</li>
          <li>Coordinate public order policing and security arrangements for community events and major gatherings.</li>
          <li>Allocate personnel, vehicles, and operational resources to ensure effective police coverage across the district.</li>
          <li>Liaise with specialist SPF departments and other Home Team agencies during major incidents and specialized investigations.</li>
          <li>Ensure compliance with SPF operational procedures, professional standards, and performance objectives.</li>
          <li>Maintain regular reporting to the Land Division Headquarters on operational activities, crime statistics, intelligence, and significant incidents.</li>
          <li>Promote public confidence by fostering strong relationships with residents, businesses, schools, and community organizations.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="neighbourhoodPolicePostModal" tabindex="-1" aria-labelledby="neighbourhoodPolicePostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/Layer4.png') }}" alt="" style="width:14px; height:14px; margin-right:8px;">
          <h5 class="modal-title" id="neighbourhoodPolicePostModalLabel">Neighbourhood Police Post (NPP)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal"><strong>Command level:</strong> Lowest-level territorial police command</p>
        <p class="p-modal"><strong>Typical Head Rank:</strong> Police Inspector (INSP) / Station Commander Level</p>
        <p class="p-modal">The NPP represents the third-tier territorial policing formation within the SPF. Operating under the command of an NPC, the NPP is the primary local police presence within residential communities. It functions as the first point of contact between the public and the police, delivering community-oriented policing, receiving reports, conducting Neighborhood patrols, gathering local intelligence, and fostering partnerships with residents, businesses, schools, and community organizations. Through its decentralized presence, the NPP enables the SPF to maintain close engagement with the public while supporting rapid response to local incidents.</p>
        <h6 class="font-weight-bold mt-3">Responsibilities:</h6>
        <ul>
          <li>Exercise day-to-day command over policing activities within the assigned Neighborhood or patrol sector.</li>
          <li>Supervise frontline police officers and community policing personnel assigned to the NPP.</li>
          <li>Receive police reports, complaints, and requests for assistance from members of the public.</li>
          <li>Conduct routine foot, bicycle, vehicle, and community patrols to deter crime and maintain public order.</li>
          <li>Respond to local incidents and provide first-response policing until additional resources arrive.</li>
          <li>Conduct preliminary investigations into minor criminal offenses and gather evidence for referral to the NPC when necessary.</li>
          <li>Collect and disseminate local intelligence relating to crime trends, public safety concerns, and emerging security risks.</li>
          <li>Build strong partnerships with residents, grassroots organizations, schools, businesses, and local stakeholders through community policing initiatives.</li>
          <li>Organize crime prevention campaigns, Neighborhood watch programs, and public safety awareness activities.</li>
          <li>Monitor vulnerable locations and support the protection of public facilities and community assets.</li>
          <li>Coordinate with the NPC, Land Division Headquarters, and specialist police units during major incidents or special operations.</li>
          <li>Maintain operational readiness, accurate records, and timely reporting of incidents, arrests, and community engagement activities.</li>
          <li>Promote public confidence in the SPF through professional, responsive, and service-oriented policing.</li>
          <li>Support national policing initiatives by implementing SPF policies and operational directives at the local community level.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&libraries=places,geometry"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const embassyData = {!! json_encode([
        'id'        => $embassy->id,
        'name'      => $embassy->name_embassiees,
        'latitude'  => $embassy->latitude,
        'longitude' => $embassy->longitude,
        'image'     => $embassy->image ?? '',
        'location'  => $embassy->location ?? '',
        'telephone' => $embassy->telephone ?? '',
        'website'   => $embassy->website ?? '',
    ]) !!};

    const nearbyHospitals = @json($nearbyHospitals);
    const nearbyAirports = @json($nearbyAirports);
    const nearbyPolices = @json($nearbyPolices);
    const nearbyEmbassy = @json($nearbyEmbassy);
    let radiusKm = 100; // default radius

    let map, mainMarker, radiusCircle, directionsService, directionsRenderer;
    let nearbyMarkersGroup = [];
    let searchLocation = null;
    let searchMarker = null;

    // === ICON DEFAULT ===
    const DEFAULT_HOSPITAL_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png';
    const DEFAULT_AIRPORT_ICON_URL  = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png';
    const DEFAULT_MAIN_EMBASSY_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png';
    const DEFAULT_POLICE_ICON_URL = 'https://png.pngtree.com/png-vector/20221211/ourmid/pngtree-minimal-location-map-icon-logo-symbol-vector-design-transparent-background-png-image_6520892.png';
    const DEFAULT_EMBASSY_ICON_URL = '/images/embassy-icon-new.png';

    // === INISIALISASI PETA ===
    function initializeMap() {
        const center = new google.maps.LatLng(embassyData.latitude, embassyData.longitude);
        map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: 11,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            fullscreenControl: true,
            streetViewControl: false
        });

        const directionsPanel = document.createElement('div');
        directionsPanel.id = 'directionsPanel';
        directionsPanel.style.width = '370px';
        directionsPanel.style.maxHeight = '450px';
        directionsPanel.style.overflowY = 'auto';
        directionsPanel.style.backgroundColor = 'white';
        directionsPanel.style.display = 'none';
        directionsPanel.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
        directionsPanel.style.borderRadius = '12px';
        directionsPanel.style.margin = '10px';
        directionsPanel.style.padding = '0';
        directionsPanel.style.fontSize = '13px';

        // Header
        const dpHeader = document.createElement('div');
        dpHeader.className = 'dp-header';
        dpHeader.innerHTML = `
            <div class="dp-header-title">
                <i class="fas fa-route"></i> Route Directions
            </div>
            <button class="dp-close-btn" title="Close">
                <i class="fas fa-times"></i>
            </button>
        `;
        directionsPanel.appendChild(dpHeader);

        // Content area (Google renders steps here)
        const dpContent = document.createElement('div');
        dpContent.style.padding = '10px';
        directionsPanel.appendChild(dpContent);

        // Close button handler
        dpHeader.querySelector('.dp-close-btn').addEventListener('click', () => {
            directionsPanel.style.display = 'none';
            directionsRenderer.setDirections({routes: []});
        });

        google.maps.event.addDomListener(directionsPanel, 'click', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'dblclick', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'mousedown', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'touchstart', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'wheel', e => e.stopPropagation());

        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(directionsPanel);

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            panel: dpContent,
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: '#1a73e8',
                strokeOpacity: 0.8,
                strokeWeight: 5
            }
        });
    }

    function addMainEmbassyAndCircle() {
        mainMarker = new google.maps.Marker({
            position: new google.maps.LatLng(embassyData.latitude, embassyData.longitude),
            map: map,
            icon: {
                url: DEFAULT_MAIN_EMBASSY_ICON_URL,
                scaledSize: new google.maps.Size(25, 41)
            },
            title: embassyData.name
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<b>${embassyData.name}</b><br>This is the main embassy.`
        });

        mainMarker.addListener('click', () => {
            infoWindow.open(map, mainMarker);
        });

        radiusCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.1,
            map: map,
            center: { lat: parseFloat(embassyData.latitude), lng: parseFloat(embassyData.longitude) },
            radius: radiusKm * 1000
        });
    }

    function clearNearbyMarkers() {
        for (let i = 0; i < nearbyMarkersGroup.length; i++) {
            nearbyMarkersGroup[i].setMap(null);
        }
        nearbyMarkersGroup = [];
    }

    // === Tambahkan Marker Sekitar ===
    function addNearbyMarkers(data, defaultIconUrl, type, filters = {}) {
        data.forEach(item => {
            const distance = calculateDistance(
                embassyData.latitude, embassyData.longitude,
                item.latitude, item.longitude
            );
            if (distance > radiusKm) return;

            // Filter hospital
            if (type === 'Hospital' && filters.hospitalLevels?.length > 0) {
                const level = (item.facility_level || '').toLowerCase();
                const allowed = filters.hospitalLevels.map(l => l.toLowerCase());
                if (!allowed.includes(level)) return;
            }

            // Filter airport
            if (type === 'Airport' && filters.airportClassifications?.length > 0) {
                const categories = (item.category || '').split(',').map(c => c.trim().toLowerCase());
                const allowed = filters.airportClassifications.map(c => c.toLowerCase());
                if (!categories.some(cat => allowed.includes(cat))) return;
            }

            // Filter police
            if (type === 'Police' && filters.policeCategories?.length > 0) {
                const categories = (item.category || '').split(',').map(c => c.trim().toLowerCase());
                const allowed = filters.policeCategories.map(c => c.toLowerCase());
                if (!categories.some(cat => allowed.includes(cat))) return;
            }

            const isPolice = type === 'Police';
            const iconSize = isPolice ? new google.maps.Size(12, 12) : new google.maps.Size(24, 24);

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) },
                map: map,
                icon: {
                    url: item.icon || defaultIconUrl,
                    scaledSize: iconSize
                }
            });

            const name = item.name || item.airport_name || item.name_police || item.name_embassiees || 'N/A';
            const level = item.facility_level || item.category || '';

            let url = '#';
            if (type === 'Airport') url = `/airports/${item.id}/detail`;
            else if (type === 'Hospital') url = `/hospitals/${item.id}`;
            else if (type === 'Police') url = `/police/${item.id}/detail`;
            else if (type === 'Embassy') url = `/embassiees/${item.id}/detail`;

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="font-size:13px;">
                        <a href="${url}" target="_blank">${name}</a><br>
                        ${level}<br>
                        <strong>Distance:</strong> ${distance.toFixed(2)} km<br>
                        <button class="btn btn-sm btn-primary mt-2"
                            onclick="getDirection(${item.latitude}, ${item.longitude})">
                            Get Direction
                        </button>
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });

            nearbyMarkersGroup.push(marker);
        });
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    // === NEARBY HOTELS (shown once a location is searched) ===
    let categoryMarkers   = [];
    let activeCategoryBtn = null;
    let categoryBar       = null;

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
        if (!searchLocation) return;
        clearCategoryMarkers();

        const center  = new google.maps.LatLng(searchLocation.lat, searchLocation.lng);
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

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="font-size:13px;min-width:190px;">
                            <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                            <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                            ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                            <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                            <button class="btn btn-sm btn-primary mt-2"
                                onclick="getDirection(${destLat}, ${destLng})">
                                Get Direction
                            </button>
                        </div>`
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                categoryMarkers.push(marker);
            });
        });
    }

    function setupNearbyCategoryBar() {
        categoryBar = document.createElement('div');
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
    }

    // === ROUTING ===
    window.getDirection = function(lat, lng) {
        const origin = searchLocation
            ? new google.maps.LatLng(searchLocation.lat, searchLocation.lng)
            : new google.maps.LatLng(embassyData.latitude, embassyData.longitude);

        directionsService.route({
            origin: origin,
            destination: new google.maps.LatLng(lat, lng),
            travelMode: 'DRIVING'
        }, (response, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
                const panel = document.getElementById('directionsPanel');
                if(panel) panel.style.display = 'block';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Route Not Found',
                    text: status === 'ZERO_RESULTS'
                        ? 'No driving route could be found between these two locations.'
                        : 'Directions request failed (' + status + ').',
                    confirmButtonColor: '#d33'
                });
            }
        });
    };

    function fitMapToBounds() {
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(new google.maps.LatLng(embassyData.latitude, embassyData.longitude));
        if (searchLocation) {
            bounds.extend(new google.maps.LatLng(searchLocation.lat, searchLocation.lng));
        }
        nearbyMarkersGroup.forEach(m => bounds.extend(m.getPosition()));

        const circleBounds = radiusCircle.getBounds();
        if(circleBounds) {
            bounds.union(circleBounds);
        }

        map.fitBounds(bounds);
    }

    function updateMarkers(filterType, hospitalLevels, airportClassifications, policeCategories) {
        clearNearbyMarkers();
        if (radiusCircle) radiusCircle.setMap(null);
        addMainEmbassyAndCircle();

        const filters = { hospitalLevels, airportClassifications, policeCategories };
        if (filterType === 'hospital') {
            addNearbyMarkers(nearbyHospitals, DEFAULT_HOSPITAL_ICON_URL, 'Hospital', filters);
        } else if (filterType === 'airport') {
            addNearbyMarkers(nearbyAirports, DEFAULT_AIRPORT_ICON_URL, 'Airport', filters);
        } else if (filterType === 'police') {
            addNearbyMarkers(nearbyPolices, DEFAULT_POLICE_ICON_URL, 'Police', filters);
        } else if (filterType === 'embassy') {
            addNearbyMarkers(nearbyEmbassy, DEFAULT_EMBASSY_ICON_URL, 'Embassy', filters);
        } else {
            addNearbyMarkers(nearbyHospitals, DEFAULT_HOSPITAL_ICON_URL, 'Hospital', filters);
            addNearbyMarkers(nearbyAirports, DEFAULT_AIRPORT_ICON_URL, 'Airport', filters);
            addNearbyMarkers(nearbyPolices, DEFAULT_POLICE_ICON_URL, 'Police', filters);
            addNearbyMarkers(nearbyEmbassy, DEFAULT_EMBASSY_ICON_URL, 'Embassy', filters);
        }

        fitMapToBounds();
    }

    // === FILTER CONTROL ===
    function setupFilterControl() {
        const container = document.createElement('div');
        container.className = 'p-2 bg-white rounded';
        container.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
        container.style.width = '220px';
        container.style.maxHeight = '75vh';
        container.style.overflowY = 'auto';
        container.style.marginRight = '10px';
        container.style.marginTop = '10px';
        container.style.cursor = 'default';

        container.innerHTML = `
            <h6><strong>Filter</strong></h6>

            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Search Location</strong>
            <div style="position:relative;margin-top:5px;">
                <input type="text" id="gmSearchInput" class="form-control form-control-sm"
                    placeholder="Search Location..." autocomplete="off" style="padding-right:28px;">
                <i class="fas fa-times" id="gmClearBtn"
                    style="position:absolute;right:8px;top:50%;transform:translateY(-50%);color:#70757a;font-size:13px;cursor:pointer;display:none;"></i>
            </div>

            <label><strong>Radius:</strong> <span id="radiusLabel">${radiusKm}</span> km</label>
            <input type="range" id="radiusRange" min="10" max="500" step="10" value="${radiusKm}" class="form-range mb-2" style="display:block;width:100%;">

            <select id="mapFilter" class="form-select form-select-sm mb-2" style="display:block;width:100%;">
                <option value="all">Show All</option>
                <option value="hospital">Hospitals</option>
                <option value="airport">Aviation</option>
                <option value="police">Police</option>
                <option value="embassy">Embassy</option>
            </select>

            <div id="hospitalFilter" style="display:none;">
                <strong>Facility Level:</strong><br>
                ${['Tertiary','Secondary','Primary']
                    .map(lvl => `<label style="display:block;font-size:13px;">
                        <input type="checkbox" name="hospitalLevel" value="${lvl}"> ${lvl}
                    </label>`).join('')}
            </div>

            <div id="airportFilter" style="display:none;margin-top:8px;">
                <strong>Category:</strong><br>
                ${['International','Domestic','Military','Regional','Private','Helipad']
                    .map(cls => `<label style="display:block;font-size:13px;">
                        <input type="checkbox" name="airportClass" value="${cls}"> ${cls}
                    </label>`).join('')}
            </div>

            <div id="policeFilter" style="display:none;margin-top:8px;">
                <strong>Police Category:</strong><br>
                ${[
                    'National Police (HQ)',
                    'Police Divisions (Land Divisions)',
                    'Neighbourhood Police Centre (NPC)',
                    'Neighbourhood Police Post (NPP)'
                ].map(cat => `
                    <label style="display:block;font-size:13px;">
                        <input type="checkbox" name="policeCategory" value="${cat}"> ${cat}
                    </label>
                `).join('')}
            </div>

            <button id="resetFilter" class="btn btn-sm btn-secondary mt-3 w-100">Reset Filter</button>
        `;

        // Prevent events from passing to the map
        google.maps.event.addDomListener(container, 'click', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'dblclick', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'mousedown', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'touchstart', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'wheel', e => e.stopPropagation());

        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(container);

        const radiusSlider = container.querySelector('#radiusRange');
        const radiusLabel = container.querySelector('#radiusLabel');
        radiusSlider.addEventListener('input', () => {
            radiusKm = parseInt(radiusSlider.value);
            radiusLabel.textContent = radiusKm;
            refreshFilters();
        });

        const filterSelect = container.querySelector('#mapFilter');
        const hospitalDiv = container.querySelector('#hospitalFilter');
        const airportDiv = container.querySelector('#airportFilter');
        const policeDiv = container.querySelector('#policeFilter');
        const resetBtn = container.querySelector('#resetFilter');

        function refresh() {
            const selectedType = filterSelect.value;
            const selectedHospitalLevels = Array.from(container.querySelectorAll('input[name="hospitalLevel"]:checked')).map(el => el.value);
            const selectedAirportClasses = Array.from(container.querySelectorAll('input[name="airportClass"]:checked')).map(el => el.value);
            const selectedPoliceCategories = Array.from(container.querySelectorAll('input[name="policeCategory"]:checked')).map(el => el.value);
            updateMarkers(selectedType, selectedHospitalLevels, selectedAirportClasses, selectedPoliceCategories);
        }

        filterSelect.addEventListener('change', () => {
            const val = filterSelect.value;
            hospitalDiv.style.display = val === 'hospital' ? 'block' : 'none';
            airportDiv.style.display = val === 'airport' ? 'block' : 'none';
            policeDiv.style.display = val === 'police' ? 'block' : 'none';
            refresh();
        });

        container.querySelectorAll('input[name="hospitalLevel"]').forEach(chk => chk.addEventListener('change', refresh));
        container.querySelectorAll('input[name="airportClass"]').forEach(chk => chk.addEventListener('change', refresh));
        container.querySelectorAll('input[name="policeCategory"]').forEach(chk => chk.addEventListener('change', refresh));

        resetBtn.addEventListener('click', () => {
            container.querySelectorAll('input[type="checkbox"]').forEach(chk => chk.checked = false);
            filterSelect.value = 'all';
            hospitalDiv.style.display = 'none';
            airportDiv.style.display = 'none';
            policeDiv.style.display = 'none';
            radiusKm = 100;
            radiusSlider.value = radiusKm;
            radiusLabel.textContent = radiusKm;

            const gmInput = container.querySelector('#gmSearchInput');
            if(gmInput) gmInput.value = '';

            if (searchMarker) {
                searchMarker.setMap(null);
                searchMarker = null;
            }
            searchLocation = null;

            if (categoryBar) categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            directionsRenderer.setDirections({routes: []});
            const panel = document.getElementById('directionsPanel');
            if(panel) panel.style.display = 'none';

            refresh();
        });

        return container;
    }

    function refreshFilters() {
        const selectedType = document.querySelector('#mapFilter')?.value || 'all';
        const selectedHospitalLevels = Array.from(document.querySelectorAll('input[name="hospitalLevel"]:checked')).map(el => el.value);
        const selectedAirportClasses = Array.from(document.querySelectorAll('input[name="airportClass"]:checked')).map(el => el.value);
        const selectedPoliceCategories = Array.from(document.querySelectorAll('input[name="policeCategory"]:checked')).map(el => el.value);
        updateMarkers(selectedType, selectedHospitalLevels, selectedAirportClasses, selectedPoliceCategories);
    }

    // === SEARCH LOCATION CONTROL (now part of the filter panel) ===
    function setupSearchControl(filterContainer) {
        const input = filterContainer.querySelector('#gmSearchInput');
        const clearBtn = filterContainer.querySelector('#gmClearBtn');
        if (!input || !clearBtn) return;

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Enter') e.preventDefault();
        });

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        // The input lives inside a custom map control, so Google's ".pac-container"
        // dropdown (appended to <body> with position:absolute) ends up clipped/
        // hidden behind the map's own control panes. Force position:fixed and keep
        // re-applying it, since Google resets the container's inline style on every
        // prediction update (a one-shot fix gets silently overwritten).
        let pacContainer = null;

        function fixPacPosition() {
            if (!pacContainer) return;
            if (pacContainer.parentElement !== document.body) {
                document.body.appendChild(pacContainer);
            }
            const rect = input.getBoundingClientRect();
            pacContainer.style.position = 'fixed';
            pacContainer.style.zIndex = '2147483647';
            pacContainer.style.top = (rect.bottom + 2) + 'px';
            pacContainer.style.left = rect.left + 'px';
            pacContainer.style.width = rect.width + 'px';
            pacContainer.style.visibility = 'visible';
            pacContainer.style.opacity = '1';
            pacContainer.style.pointerEvents = 'auto';
        }

        function claimPacContainer() {
            if (pacContainer) return true;
            pacContainer = document.querySelector('.pac-container');
            if (pacContainer) {
                fixPacPosition();
                new MutationObserver(fixPacPosition).observe(
                    pacContainer, { attributes: true, attributeFilter: ['style'] }
                );
                return true;
            }
            return false;
        }

        const pacObserver = new MutationObserver(() => claimPacContainer());
        pacObserver.observe(document.body, { childList: true, subtree: true });

        // Fallback in case Google created ".pac-container" before the observer
        // above started watching (a MutationObserver only reports *future*
        // mutations, so a container created earlier would otherwise be missed).
        if (!claimPacContainer()) {
            const pollId = setInterval(() => {
                if (claimPacContainer()) clearInterval(pollId);
            }, 200);
            setTimeout(() => clearInterval(pollId), 10000);
        }

        window.addEventListener('scroll', fixPacPosition, true);
        window.addEventListener('resize', fixPacPosition);
        input.addEventListener('focus', fixPacPosition);
        input.addEventListener('input', fixPacPosition);

        input.addEventListener('input', (e) => {
            if (e.target.value.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        });

        clearBtn.addEventListener('click', () => {
            input.value = '';
            clearBtn.style.display = 'none';
            input.focus();
            if (pacContainer) pacContainer.style.display = 'none';

            if (searchMarker) {
                searchMarker.setMap(null);
                searchMarker = null;
            }
            searchLocation = null;

            if (categoryBar) categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            directionsRenderer.setDirections({routes: []});
            const panel = document.getElementById('directionsPanel');
            if(panel) panel.style.display = 'none';
        });

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                return;
            }

            if (searchMarker) searchMarker.setMap(null);

            searchMarker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                icon: {
                    url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    scaledSize: new google.maps.Size(25, 41)
                }
            });

            const lat = place.geometry.location.lat();
            const lon = place.geometry.location.lng();
            searchLocation = { lat: lat, lng: lon };

            if (categoryBar) categoryBar.style.display = 'flex';

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="font-size:13px;">
                        <b>${place.name}</b><br>
                        <small>Lat: ${lat.toFixed(5)}, Lng: ${lon.toFixed(5)}</small><br>
                        <button class="btn btn-sm btn-primary mt-2"
                            onclick="getDirection(${embassyData.latitude}, ${embassyData.longitude})">
                            Get Direction to Main Embassy
                        </button>
                    </div>
                `
            });

            infoWindow.open(map, searchMarker);
            searchMarker.addListener('click', () => {
                infoWindow.open(map, searchMarker);
            });

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(14);
            }
        });
    }

    // === JALANKAN ===
    initializeMap();
    addMainEmbassyAndCircle();
    updateMarkers('all', [], [], []);
    const filterContainer = setupFilterControl();
    setupSearchControl(filterContainer);
    setupNearbyCategoryBar();
});
</script>

@endpush
