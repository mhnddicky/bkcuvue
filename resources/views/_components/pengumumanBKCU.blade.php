<!-- pengumuman -->
<div class="content-wrap nobottommargin nobottompadding">
  <div class="section dark header-stick nobottommargin clearfix" style="padding: 30px 0;">
    <div>
      <div class="container clearfix">
        <span class="badge badge-danger bnews-title">Pengumuman:</span>

        <div class="fslider bnews-slider nobottommargin nobottompadding" data-speed="800" data-pause="6000" data-arrows="false" data-pagi="false">
          <div class="flexslider">
            <div class="slider-wrap">
              @foreach($birthdayList as $item)
              <div class="slide">PUSKOPCUINA mengucapkan selamat ulang tahun kepada CU {{ $item->name }} ke - {{ $item->usia }}, semoga terus berkarya</div>
              @endforeach
              @foreach($pengumumanBKCUList as $item)
              <div class="slide">{{ $item->name }}</div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>