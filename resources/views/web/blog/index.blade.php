<!DOCTYPE html>
<html lang="en">

@include('web.layouts.head')

<body>
    
    <header class="BgScrollEffect"style = " height: 200px">
        <div class="BackgroundImage" ></div>
        
        <!-- Include navbar -->
        @include('web.layouts.navbar')

    </header>
    
    <section class="MakeAppointment">
      <div class="container WrapHeadingContent" >
        <div class="HeadingContent  ElementScrollEffect left">
          <h3 class="heading">Flag - Tieeu dde bai viet</h3>
          <span class="dash"></span>
            <h5 class="heading--sub">...</h5>
        
        </div>
        <div class="row" id ="blog-content">
            aaaa
        </div>
    </div>
    </section>

    @include('web.layouts.foot')

    @include('web.layouts.footer')
</body>

</html>