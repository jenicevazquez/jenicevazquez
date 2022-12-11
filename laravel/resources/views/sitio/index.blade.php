
@extends('sitio.layout')
@section('header-content')
    <div class="pageheader-content row">
        <div class="col-full">
            <div class="featured">
                <div class="featured__column featured__column--big">
                    <div class="entry" style="background-image:url({!! $articulos[0]->imagen !!})">
                        <div class="entry__content">
                            <span class="entry__category"><a href="#0">{!! $articulos[0]->categoriaRow->categoria or '' !!}</a></span>
                            <h1><a href="/blog/{!! $articulos[0]->id !!}/{!! $articulos[0]->slug !!}" title="">{!! $articulos[0]->titulo !!}</a></h1>
                            <div class="entry__info">
                                <a href="/blog/{!! $articulos[0]->id !!}/{!! $articulos[0]->slug !!}" class="entry__profile-pic">
                                    <img class="avatar" src="images/avatars/xuser-03.jpg.pagespeed.ic.zxKv6LRWqd.webp" alt="" data-pagespeed-url-hash="635111699" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                </a>
                                <ul class="entry__meta">
                                    <li>{!! $articulos[0]->fecha_str !!}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="featured__column featured__column--small">
                    @if(isset($articulos[1]))
                        <div class="entry" style="background-image:url(https://via.placeholder.com/150)">
                            <div class="entry__content">
                                <span class="entry__category"><a href="#0">Management</a></span>
                                <h1><a href="#0" title="">The Pomodoro Technique Really Works.</a></h1>
                                <div class="entry__info">
                                    <a href="#0" class="entry__profile-pic">
                                        <img class="avatar" src="images/avatars/xuser-03.jpg.pagespeed.ic.zxKv6LRWqd.webp" alt="" data-pagespeed-url-hash="635111699" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                    </a>
                                    <ul class="entry__meta">
                                        <li><a href="#0">John Doe</a></li>
                                        <li>December 27, 2017</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($articulos[2]))
                        <div class="entry" style="background-image:url(https://via.placeholder.com/150)">
                            <div class="entry__content">
                                <span class="entry__category"><a href="#0">LifeStyle</a></span>
                                <h1><a href="#0" title="">Throwback To The Good Old Days.</a></h1>
                                <div class="entry__info">
                                    <a href="#0" class="entry__profile-pic">
                                        <img class="avatar" src="images/avatars/xuser-03.jpg.pagespeed.ic.zxKv6LRWqd.webp" alt="" data-pagespeed-url-hash="635111699" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                    </a>
                                    <ul class="entry__meta">
                                        <li><a href="#0">John Doe</a></li>
                                        <li>December 21, 2017</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('main-content')
    <section class="s-content">
        <div class="row masonry-wrap">
        <div class="masonry">
            <div class="grid-sizer"></div>
            <article class="masonry__brick entry format-standard" data-aos="fade-up">
                <div class="entry__thumb">
                    <a href="single-standard.html" class="entry__thumb-link">
                        <img style="width: 100%" src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150 1x,https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="3576102722" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    </a>
                </div>
                <div class="entry__text">
                    <div class="entry__header">
                        <div class="entry__date">
                            <a href="single-standard.html">December 15, 2017</a>
                        </div>
                        <h1 class="entry__title"><a href="single-standard.html">Just a Standard Format Post.</a></h1>
                    </div>
                    <div class="entry__excerpt">
                        <p>
                            Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id et sit proident dolor nulla sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit sint in aliqua...
                        </p>
                    </div>
                    <div class="entry__meta">
<span class="entry__meta-links">
<a href="category.html">Design</a>
<a href="category.html">Photography</a>
</span>
                    </div>
                </div>
            </article>
            <article class="masonry__brick entry format-quote" data-aos="fade-up">
                <div class="entry__thumb">
                    <blockquote>
                        <p>Good design is making something intelligible and memorable. Great design is making something memorable and meaningful.</p>
                        <cite>Dieter Rams</cite>
                    </blockquote>
                </div>
            </article>
            <article class="masonry__brick entry format-video" data-aos="fade-up">
                <div class="entry__thumb video-image">
                    <a href="https://player.vimeo.com/video/117310401?color=01aef0&title=0&byline=0&portrait=0" data-lity>
                        <img style="width: 100%" src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150 1x, https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="2059947561" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    </a>
                </div>
                <div class="entry__text">
                    <div class="entry__header">
                        <div class="entry__date">
                            <a href="single-video.html">December 10, 2017</a>
                        </div>
                        <h1 class="entry__title"><a href="single-video.html">Key Benefits Of Family Photography.</a></h1>
                    </div>
                    <div class="entry__excerpt">
                        <p>
                            Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id et sit proident dolor nulla sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit sint in aliqua...
                        </p>
                    </div>
                    <div class="entry__meta">
<span class="entry__meta-links">
<a href="category.html">Family</a>
<a href="category.html">Photography</a>
</span>
                    </div>
                </div>
            </article>
            <article class="masonry__brick entry format-gallery" data-aos="fade-up">
                <div class="entry__thumb slider">
                    <div class="slider__slides">
                        <div class="slider__slide">
                            <img style="width: 100%" src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150p 1x, https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="1163719775" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        </div>
                        <div class="slider__slide">
                            <img style="width: 100%" src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150 1x, https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="1584282112" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        </div>
                        <div class="slider__slide">
                            <img style="width: 100%" src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150 1x, https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="2004844449" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        </div>
                    </div>
                </div>
                <div class="entry__text">
                    <div class="entry__header">
                        <div class="entry__date">
                            <a href="single-gallery.html">December 10, 2017</a>
                        </div>
                        <h1 class="entry__title"><a href="single-gallery.html">Workspace Design Trends and Ideas.</a></h1>
                    </div>
                    <div class="entry__excerpt">
                        <p>
                            Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id et sit proident dolor nulla sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit sint in aliqua...
                        </p>
                    </div>
                    <div class="entry__meta">
<span class="entry__meta-links">
<a href="category.html">Work</a>
<a href="category.html">Management</a>
</span>
                    </div>
                </div>
            </article>
            <article class="masonry__brick entry format-audio" data-aos="fade-up">
                <div class="entry__thumb">
                    <a href="single-audio.html" class="entry__thumb-link">
                        <img style="width: 100%"  src="https://via.placeholder.com/150" srcset="https://via.placeholder.com/150 1x, https://via.placeholder.com/150 2x" alt="" data-pagespeed-url-hash="3900247462" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    </a>
                    <div class="audio-wrap">
                        <audio id="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" width="100%" height="42" controls></audio>
                    </div>
                </div>
                <div class="entry__text">
                    <div class="entry__header">
                        <div class="entry__date">
                            <a href="single-audio.html">December 10, 2017</a>
                        </div>
                        <h1 class="entry__title"><a href="single-audio.html">What Your Music Preference Says About You and Your Personality.</a></h1>
                    </div>
                    <div class="entry__excerpt">
                        <p>
                            Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id et sit proident dolor nulla sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit sint in aliqua...
                        </p>
                    </div>
                    <div class="entry__meta">
<span class="entry__meta-links">
<a href="category.html">Music</a>
<a href="category.html">Lifestyle</a>
</span>
                    </div>
                </div>
            </article>
            <article class="masonry__brick entry format-link" data-aos="fade-up">
                <div class="entry__thumb">
                    <div class="link-wrap">
                        <p>The Only Resource You Will Need To Start a Blog Using WordPress.</p>
                        <cite>
                            <a target="_blank" href="https://colorlib.com/">https://colorlib.com</a>
                        </cite>
                    </div>
                </div>
            </article>
        </div>
    </div>
        <div class="row">
        <div class="col-full">
            <nav class="pgn">
                <ul>
                    <li><a class="pgn__prev" href="#0">Prev</a></li>
                    <li><a class="pgn__num" href="#0">1</a></li>
                    <li><span class="pgn__num current">2</span></li>
                    <li><a class="pgn__num" href="#0">3</a></li>
                    <li><a class="pgn__num" href="#0">4</a></li>
                    <li><a class="pgn__num" href="#0">5</a></li>
                    <li><span class="pgn__num dots">…</span></li>
                    <li><a class="pgn__num" href="#0">8</a></li>
                    <li><a class="pgn__next" href="#0">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
    </section>
@endsection
