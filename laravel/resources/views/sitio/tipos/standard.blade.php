@extends('sitio.layout2')
@section('web-title',$articulo->titulo.' | Jenice Vazquez')
@section('main-content')
    <section class="s-content s-content--narrow s-content--no-padding-bottom">
        <article class="row format-standard">
            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    {!! $articulo->titulo !!}
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date">{!! $articulo->fecha_str !!}</li>
                    <li class="cat">
                        En
                        <a href="#0">{!! $articulo->categoriaRow->categoria !!}</a>
                    </li>
                </ul>
            </div>
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <img src="{!! $articulo->imagen !!}" alt="" data-pagespeed-url-hash="1246392733" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </div>
            </div>
            <div class="col-full s-content__main">
                <p>{!! $articulo->texto !!}</p>
                <p class="s-content__tags">
                    <span>Etiquetas del articulo</span>
                    <span class="s-content__tag-list">
                        @foreach($articulo->tags as $tag)
                            <a href="#0">{!! $tag->etiqueta !!}</a>
                        @endforeach
                    </span>
                </p>
                <div class="s-content__author">
                    <img src="{!! $articulo->autorRow->imagen !!}" alt="" data-pagespeed-url-hash="635111699" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    <div class="s-content__author-about">
                        <h4 class="s-content__author-name">
                            <a href="#0">{!! $articulo->autorRow->name !!}</a>
                        </h4>
                        <p>{!! $articulo->autorRow->about !!}</p>
                    </div>
                </div>
                <div class="s-content__pagenav">
                    <div class="s-content__nav">
                        <div class="s-content__prev">
                            <a href="#0" rel="prev">
                                <span>Articulo anterior</span>
                                Tips on Minimalist Design
                            </a>
                        </div>
                        <div class="s-content__next">
                            <a href="#0" rel="next">
                                <span>Siguiente articulo</span>
                                Less Is More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <div class="comments-wrap">
            <div id="comments" class="row">
                <div class="col-full">
                    <h3 class="h2">5 Comentarios</h3>

                    <ol class="commentlist">
                        <li class="depth-1 comment">
                            <div class="comment__avatar">
                                <img class="avatar" src="data:image/webp;base64,UklGRoQDAABXRUJQVlA4IHgDAAAwEACdASoyADIAPm0okUYkIiGhMBYM+IANiWIAxq+JyZSO7h3Zw7nvkt1/Nf7cDDRRks4xxejNoGfoSd828pvsN15UZyZ5Gabyb0Kdc/aKOD7r3Cz8kmZWRjJvWRK8ki5R5XtvGmdHwWmypqKFzf0oCo6i3i5SBxaObnEy2njAkO4lcK2f4c8ozcAA/vzsceDI4a6iIpT9/kydXq2FeAmzV34JAULhzbER3z3IwZS2uwV85usnuA9SJGH/pe8IPIbTuDTV1qV26ocPJIqrTA9UoimjbPCj8r+WMXSy2hGi35i1AQd8r3Axfn10+yasGlU4ndJBKOHzknGoHQJ7chKNuWVMn6uJJZIkqLsQdvLcjgtlxFIEqIey7SCAgAyyHFNSqAx+gUzmuIOQO+V9UeQsClZvCnMmjWTUDHnDYVMnrDtmP7Pl/jmjEJ5pyN5Cd5bu0/rUMJA3rEf8X51+U4kfxgfeCJPvvGvxNr0DNJ5P28/p3qxJfquesN+YDWF5mAbpavq3r+bGW/6ExSKO6T/45yxt74h7llb87ZWPwg79L7U3lgUNfjHEit+FUleMXYSGTg5WwqIkO8DEDj1BmCaCUTdr4xWuDbTRorwjpXvvbjH+Kaits3EUV1heepH6aHgyfxbwPbmfmCC3az/Dg8gfkZ+w5ZTyawawzanHaa5/lqhZVqVfRL8D5rhQemiylA8IfEiEWyut63Y0ULBRVdJHlLChX8vNkpiLvxaEOHK3zXjeAAYkr885mRTI7fh+smvJ+8TxtVk6OKDW5Xu2KpxGyYrc8YIWsTwbmbPhCHQn6Gk5JhchBxzNk6mH9JuwmxV6V9lYeJ1h0ymA3hego/JPaPeNn/jT5cMfc6OzmzyLUAxv7KUpfNiVo7HOc3HGKLJrTbp/pwyaBlVLMIRe4K6tFqUo62VFTCj/YXn+e/lr3jY4NXlTjRoKAH0p4uusm6hMm99i8tDeNK9zrlZsxuYGiIrNaAWddUbB46joOU33kVZFUwGodWIIXgzUzvOtnVfbIoMwpxT40A2tw2EAv9GEiM/e80sQQJAcYcwcb1xLhytk8JmE/Bw5rUZGu4Z7U9m4gDFuGMSSm0t35BA2nW9nAuh4IzUI+mFScdebuoB1wlXKJAvEDUVuWAjn/0cukTf8lymGQds/inLvxGILHf09wJ+gtCzyAAA=" alt="" data-pagespeed-url-hash="46111857" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                            </div>
                            <div class="comment__content">
                                <div class="comment__info">
                                    <cite>Itachi Uchiha</cite>
                                    <div class="comment__meta">
                                        <time class="comment__time">Dec 16, 2017 @ 23:05</time>
                                        <a class="reply" href="#0">Reply</a>
                                    </div>
                                </div>
                                <div class="comment__text">
                                    <p>Adhuc quaerendum est ne, vis ut harum tantas noluisse, id suas iisque mei. Nec te inani ponderum vulputate,
                                        facilisi expetenda has et. Iudico dictas scriptorem an vim, ei alia mentitum est, ne has voluptua praesent.</p>
                                </div>
                            </div>
                        </li>
                        <li class="thread-alt depth-1 comment">
                            <div class="comment__avatar">
                                <img class="avatar" src="data:image/webp;base64,UklGRgADAABXRUJQVlA4IPQCAABQDQCdASoyADIAPm0skkWkIqGYDAWAQAbEsoBihiNFy1x14XWg4GWjpy2fPQFJyY3CfamsuGT/p2/UCY2dtMDD0erd9qV/JIIGLEpY55kK8ZvU3TO7G+4BgRElxgNRI2UC1pdu3AQ/9n5B4BIAN5qhz5NIAP73gLeJDvB2bGq0OMuXJWIuJdIIluAnGC47833N8H6b+5v0art8Rk1Z6z3ltksJMTtGwTBMPLCXs7abnfkGnALKe/tscB7KpPI+Sbc5jFcyyKDTxad46bbQC0TMBOGbEC5wcW59y86WHqWn8lrpJNx5Ut4PZF+B9LjggQcqFlYd1D7hgo5FIuE8dEIP4o2YwyUvE3Z/2F5vpkNttdWzVAKMCnO4AUjQSfIBO9wbcsr55VhXM2zwqhZ3vkbyqRIttviJkuPOrjJYoHobZy+SKB2Wn4A/cH6VZT1Q+FVV/gw9U8dHZvLC7BoFYr3HA0pWTxgqvUeBPzGZquZrqtQx3K1ccFTIUFJiZ/h+HLfqt6ao4nw8RfXcQeuEre5uRk9iV/oKhbpvTLXArwHgcU5qkhsvFwBOZ4HIJ4g8H5CtSheROQTLgxr54yPpH8jl0nRT4wqORlhu655qVofn8EEbqCLm7Dozey6+KcrSc+vzFggMdc2k3+cskY4/PWHBPWbSHLZivZBesmCteNyqZ21784Xg+///GIm9VohzQr1klqAvByIlB5+wta2iLzXYtjzP1IDaNeDPveZAn4vK3kQUyIxhxkJpiVa7CFa4knSFSb+tygAUi0do/u1g518OIeFh8Voo5h3qicTTBtylFxEyGNsbdaezUWqMfS3vVQ2Z1PNx6U7Vsx4d+7DKddQymIZFXJYscgRcGEfu3OgTsLFFiQeM/b8M9GL8K/U/fftQUc1QhgCZgS3Pgyn/aEF07s36inn3iIWhr1ehSUeAtVSKYwlTF5YZnn+98HUBsgiplvBJbq/atsMpLrFFolHz/MWOPUaTkC/JfljkCeqFArQAAAA=" alt="" data-pagespeed-url-hash="929611620" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                            </div>
                            <div class="comment__content">
                                <div class="comment__info">
                                    <cite>John Doe</cite>
                                    <div class="comment__meta">
                                        <time class="comment__time">Dec 16, 2017 @ 24:05</time>
                                        <a class="reply" href="#0">Reply</a>
                                    </div>
                                </div>
                                <div class="comment__text">
                                    <p>Sumo euismod dissentiunt ne sit, ad eos iudico qualisque adversarium, tota falli et mei. Esse euismod
                                        urbanitas ut sed, et duo scaevola pericula splendide. Primis veritus contentiones nec ad, nec et
                                        tantas semper delicatissimi.</p>
                                </div>
                            </div>
                            <ul class="children">
                                <li class="depth-2 comment">
                                    <div class="comment__avatar">
                                        <img class="avatar" src="data:image/webp;base64,UklGRqIDAABXRUJQVlA4IJYDAADwEACdASoyADIAPm0wkkWkIyGiqhmdyIANiWIAguNB/Js6N6LHc27Gh/vjH4Q+GpJP+q4Y5YDAjTHzUPIl9SbsAgfe5g1Lvec3Bx+p1oo/8Ybpj2rsYiYRQcv4gmUuW0VBYVCZqaLtF+UsypOs+mL2qBB43kAAIzzqX3lDEPGTu98NdMAqdN1QDal1pVFqdAAA/v4wI0DE/fwJMYuVs8+nlNJ3rD+VacQTy6PQLvTGDPgl3RgLrWgQGp043VV4palKmx2SeFgsbzkoN6jyqYExXQ6XK+bJ96sL1MdHSQ26ro40ZHoMCCy1DKx1ig52XaLALDdo3eQkSzUL3rdTqbxMyAf3WtHStwZWvmws5gV1c+E0SgsZkOlFUNcdAUGx8VOyqDnHLrcAs2zwySsNNEvWq0bCpCj7SfcL2pdrDU7IL4k0AHLXmHJPosYUMEUn2K8arHykWkZEKqdtTPs1/6yiE43jUuqUHXofHVIK8Lfip3xSZLkKuFj/+oakQe/iydckBujVhuFbCDTsmfTk8LF2/iqsZR3eV7il79AGu/LdLHhSZLiX2DizwA8xW7ZVMgdUfqjQX7cRpvJl9/ui5DTeZoGKZ8yEYCZC6LXbt193LhTMt1Lzzf16v8IJyl7jcn2s7ZkbM7w4B10WFdCsf6N7RJK0p+L1i/DAdgvGCExviLW6R8Q4j2mtUjoNYfXXpC2KKx+B0hUUlS/wf7OoaWlbEbD76j/k23ZBC6/wrdwuG2gyhSiWWbb7S4s+umo9xSJEXrW1K6vIefc7VZ8Rgw575eyz67V8QEbDO9TbvhOoiTa3rSsnG4TOkYDT+5f7/AN6KaJqCK4Yngg+kPAhpPDG59T3u5/zhXuuHWKtgNPvkVC7Bhoq2xmdAuIxcz6zx7IICINLmfGSc4JF8VEHBoCZkOwfi2XweiF28NSVjLje0AKA7N0Bo1OadzXUJtbJ9QsGF7vLGnFPdi2yBOYL004P61q9mKu1lBxC6FPHkYhWfiTwWdFYJnCobbDC3B1RNLinwFMd7GOLUhrICC/EklIxeOuRtl/xtrZcUMDHbegmhr9t/8ECB3TgT1DlPxTFApZ+qUff7bTRxH/fqAW+wAlmtGePMPkEvoCGNL3d777oBtNVpSh9rBQUiQQbjk5dBnEw85qmZc3cgOVzHX5JcoaP+9gIa5N0m/RVU/0VZ7/DS4x/9mloAAK9SYqIC24qUhl+ZrbAAAA=" alt="" data-pagespeed-url-hash="635111699" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                    </div>
                                    <div class="comment__content">
                                        <div class="comment__info">
                                            <cite>Kakashi Hatake</cite>
                                            <div class="comment__meta">
                                                <time class="comment__time">Dec 16, 2017 @ 25:05</time>
                                                <a class="reply" href="#0">Reply</a>
                                            </div>
                                        </div>
                                        <div class="comment__text">
                                            <p>Duis sed odio sit amet nibh vulputate
                                                cursus a sit amet mauris. Morbi accumsan ipsum velit. Duis sed odio sit amet nibh vulputate
                                                cursus a sit amet mauris</p>
                                        </div>
                                    </div>
                                    <ul class="children">
                                        <li class="depth-3 comment">
                                            <div class="comment__avatar">
                                                <img class="avatar" src="data:image/webp;base64,UklGRgADAABXRUJQVlA4IPQCAABQDQCdASoyADIAPm0skkWkIqGYDAWAQAbEsoBihiNFy1x14XWg4GWjpy2fPQFJyY3CfamsuGT/p2/UCY2dtMDD0erd9qV/JIIGLEpY55kK8ZvU3TO7G+4BgRElxgNRI2UC1pdu3AQ/9n5B4BIAN5qhz5NIAP73gLeJDvB2bGq0OMuXJWIuJdIIluAnGC47833N8H6b+5v0art8Rk1Z6z3ltksJMTtGwTBMPLCXs7abnfkGnALKe/tscB7KpPI+Sbc5jFcyyKDTxad46bbQC0TMBOGbEC5wcW59y86WHqWn8lrpJNx5Ut4PZF+B9LjggQcqFlYd1D7hgo5FIuE8dEIP4o2YwyUvE3Z/2F5vpkNttdWzVAKMCnO4AUjQSfIBO9wbcsr55VhXM2zwqhZ3vkbyqRIttviJkuPOrjJYoHobZy+SKB2Wn4A/cH6VZT1Q+FVV/gw9U8dHZvLC7BoFYr3HA0pWTxgqvUeBPzGZquZrqtQx3K1ccFTIUFJiZ/h+HLfqt6ao4nw8RfXcQeuEre5uRk9iV/oKhbpvTLXArwHgcU5qkhsvFwBOZ4HIJ4g8H5CtSheROQTLgxr54yPpH8jl0nRT4wqORlhu655qVofn8EEbqCLm7Dozey6+KcrSc+vzFggMdc2k3+cskY4/PWHBPWbSHLZivZBesmCteNyqZ21784Xg+///GIm9VohzQr1klqAvByIlB5+wta2iLzXYtjzP1IDaNeDPveZAn4vK3kQUyIxhxkJpiVa7CFa4knSFSb+tygAUi0do/u1g518OIeFh8Voo5h3qicTTBtylFxEyGNsbdaezUWqMfS3vVQ2Z1PNx6U7Vsx4d+7DKddQymIZFXJYscgRcGEfu3OgTsLFFiQeM/b8M9GL8K/U/fftQUc1QhgCZgS3Pgyn/aEF07s36inn3iIWhr1ehSUeAtVSKYwlTF5YZnn+98HUBsgiplvBJbq/atsMpLrFFolHz/MWOPUaTkC/JfljkCeqFArQAAAA=" alt="" data-pagespeed-url-hash="929611620" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                            </div>
                                            <div class="comment__content">
                                                <div class="comment__info">
                                                    <cite>John Doe</cite>
                                                    <div class="comment__meta">
                                                        <time class="comment__time">Dec 16, 2017 @ 25:15</time>
                                                        <a class="reply" href="#0">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="comment__text">
                                                    <p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est
                                                        etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="depth-1 comment">
                            <div class="comment__avatar">
                                <img class="avatar" src="data:image/webp;base64,UklGRj4DAABXRUJQVlA4IDIDAACwDgCdASoyADIAPmkmkEWkIiGa+u5kQAaEoAxQumTmSSdEY2ENXy0aOGfNv6DIB37dqveUYD6XRnstruqDpeawWG7wkXiOCQtYINM2q+fS78ejKrIyx8JQfq98L0UNOPpGx9iUxfe3iM4rIFjNxFGXdgoxwcRoZRRUxkFFlAAA/v6sKA5OetG6TN/o9chZdpvLF7P+rHFVUE58ClfoksQI3oJWTyCtKEBgO65oS8TpoQidTCp4kPFWRohaAXNq47a7xrr9Gl4sKW0CFRSvi28MzDAhqGZri+sLeGj5z8QEWUo0tYgxCRjpPUrje0GDz5LHrEWbBJoLzhT5dYEfZ4FVRIAYc/hlHMWZr1pH+YMzv/Utlgx/f3h+NFKcWS5+ED9DrIsseqPz8+jYAAluPab+xY1tL5QE2z39rtWnO8ehIA6ukU0TQTOt2pAhuWbzZK76sGigL4XPRYIqzr12/kSm1TDxoOi+KTFsP9Kt8usd1FWwPnDNK8J69VvUgwk8LM0KK4NehfPoChUNLpDFRxQWjkc+V4gzepQQV1w0oUHapum+ICTjciLvlGSGuVhY9vIeVRWyCZ67PylarLeSZ/DxUfGKLyH7GffKCO08OAu2/76c8EE2Da+7XoqIb40dASQx8NbghAR2TWs7UBi10Jhn7V1y6c2d1uu3u+8j7OJBO4XF+l3lRi0nwTckHfa4vSuSNk2JGmgPtBKJjFqLoAj7ufk1aQ7KDtQQke9z7AnoiQKpKj5bnvcKrf+fMdTuhs18RkNmVujZnEEw0flw0Wh10/jUfdTFMwNlWNVcsRfVakC5uC1/4qvhKm080eLsUc/neEjhzvQyKce5aT+W9FDFk9BlStiNzNkrEsP9Mjs2yxd3rfQ4F24fEYLOplAjoH+ydSqVfbzdIKHjEwokTGEu851Jal6fvr+Ag9rvf80vzYPJ1X/x3K2C53mIvHm6Ll92+KPr3BNvd447PJip/uDgqS3ntj+fyFgWlDAl26m4r3oJ/V5R3gEkTv6ZlNRSgjRhd568Vf3L1uK0bNu5CYV1EBr1nLbdD0ZnnwMnEAGmn19od7gZ318nycs2Qto8/wAAAA==" alt="" data-pagespeed-url-hash="340611778" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                            </div>
                            <div class="comment__content">
                                <div class="comment__info">
                                    <cite>Shikamaru Nara</cite>
                                    <div class="comment__meta">
                                        <time class="comment-time">Dec 16, 2017 @ 25:15</time>
                                        <a class="reply" href="#">Reply</a>
                                    </div>
                                </div>
                                <div class="comment__text">
                                    <p>Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.</p>
                                </div>
                            </div>
                        </li>
                    </ol>

                    <div class="respond">
                        <h3 class="h2">Agregar Comentario</h3>
                        <form name="contactForm" id="contactForm" method="post" action="">
                            <fieldset>
                                <div class="form-field">
                                    <input name="cName" type="text" id="cName" class="full-width" placeholder="Tu Nombre" value="">
                                </div>
                                <div class="form-field">
                                    <input name="cEmail" type="text" id="cEmail" class="full-width" placeholder="Tu Email" value="">
                                </div>
                                <div class="message form-field">
                                    <textarea name="cMessage" id="cMessage" class="full-width" placeholder="Tu Mensaje"></textarea>
                                </div>
                                <button type="submit" class="submit btn--primary btn--large full-width">Enviar</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection