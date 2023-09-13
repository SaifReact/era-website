<!-- ======= Counts Section ======= -->
<section id="counts" class="counts">
    <div class="container" data-aos="fade-up">
        <div class="conutbox-wrapper">
            <div class="count-box">
                <i class="bi bi-people"></i>
                <div>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->team_members }}"
                        data-purecounter-duration="1"
                        class="purecounter"></span>@if($resourceInfo->team_members)<span>+</span>@endif
                    <p>Team Members</p>
                </div>
            </div>
            <div class="count-box">
                <i class="bi bi-headset"></i>
                <div>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->customers }}"
                        data-purecounter-duration="1"
                        class="purecounter"></span>@if($resourceInfo->customers)<span>+</span>@endif
                    <p>Customers</p>
                </div>
            </div>
            <div class="count-box">
                <i class="bi bi-journal-richtext"></i>
                <div>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->number_of_installation }}"
                        data-purecounter-duration="1"
                        class="purecounter"></span>@if($resourceInfo->number_of_installation)<span>+</span>@endif
                    <p>No of Installation</p>
                </div>
            </div>
            <div class="count-box">
                <i class="bi bi-emoji-smile"></i>
                <div>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $resourceInfo->commencement }}"
                        data-purecounter-duration="1"
                        class="purecounter"></span>@if($resourceInfo->commencement)<span></span>@endif
                    <p>Establishment</p>
                </div>
            </div>
        </div>

    </div>
</section><!-- End Counts Section -->