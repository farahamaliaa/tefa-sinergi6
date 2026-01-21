@php
    use App\Enums\SemesterEnum;
    use Carbon\Carbon;
@endphp

<style>
    .card-thick {
        border: 1px solid #d6d6d6 !important;
        box-shadow: none !important;
    }
</style>

<div class="card card-body  card-thick rounded-3">
    <div class="tab-content mt-4">
        <div class="tab-pane fade show active" id="pills-ganjil" role="tabpanel">

            <div class="position-relative mb-4"
                 style="background: #149fd8; border-radius: 12px; height: 180px; overflow:hidden;">

                <div class="position-absolute start-0 p-3 d-flex align-items-center gap-2"
                    style="top: 50%; transform: translateY(-50%); opacity: 0.9;">
                    <svg width="80" height="80" viewBox="0 0 32 28" fill="none">
                        <path fill="#ffffff"
                            d="M4.125 0V8.25H1.375V0H4.125ZM1.375 27.5V19.25H4.125V27.5H1.375ZM5.5 13.75C5.5 15.2762 4.27625 16.5 2.75 16.5C2.2061 16.5 1.67442 16.3387 1.22218 16.0365C0.769948 15.7344 0.417473 15.3049 0.209332 14.8024C0.00119152 14.2999 -0.0532676 13.7469 0.0528417 13.2135C0.158951 12.6801 0.420863 12.1901 0.805457 11.8055C1.19005 11.4209 1.68005 11.1589 2.2135 11.0528C2.74695 10.9467 3.29988 11.0012 3.80238 11.2093C4.30488 11.4175 4.73437 11.7699 5.03654 12.2222C5.33872 12.6744 5.5 13.2061 5.5 13.75ZM20.625 2.75C26.7025 2.75 31.625 7.6725 31.625 13.75C31.625 19.8275 26.7025 24.75 20.625 24.75C15.675 24.75 11.495 21.4775 10.1063 16.9812L6.875 13.75L10.1063 10.5187C11.495 6.0225 15.675 2.75 20.625 2.75ZM20.625 5.5C16.0737 5.5 12.375 9.19875 12.375 13.75C12.375 18.3012 16.0737 22 20.625 22C25.1762 22 28.875 18.3012 28.875 13.75C28.875 9.19875 25.1762 5.5 20.625 5.5ZM19.25 15.125V8.25H21.3125V14.025L25.4375 16.5L24.31 18.2325L19.25 15.125Z"/>
                    </svg>

                    <h6 class="mb-0 text-white"  style="font-size: 1.5rem !important;">Semester Saat Ini :</h6>
                </div>


                <div class="position-absolute top-50 start-50 translate-middle text-center">
                    <h1 class="text-white pt-3 fw-bold">{{ Str::upper($currentSemester) }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
