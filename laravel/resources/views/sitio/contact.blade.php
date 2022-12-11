@extends('sitio.layout')
@section('main-content')
    <section class="s-content s-content--narrow">
        <div class="row">
            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    Contacto
                </h1>
            </div>
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <img src="/img/sitio/contact2.png" alt="Jenice Vazquez" data-pagespeed-url-hash="899122130" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </div>
            </div>
            <div class="col-full s-content__main">
                <p class="lead">En realidad, soy una persona muy fácil de contactar. Lo más sencillo y práctico es
                    escribirme un email a <a href="mailto:jenice.vazquez@hotmail.com">jenice.vazquez@hotmail.com</a> que suelo contestar en breve.
                    Si es algo en la que necesitemos charlar puedes enviarme un mensaje por <a target="_blank" href="https://www.facebook.com/codigojenice">Facebook.</a></p>
                <p>
                    Si nos conocemos y me tienes registrado en tus contactos, te recomiendo que mejor me mandes un Whatsapp :)
                </p>
                <h3>Y aún mas fácil, puedes enviarme un mensaje en el siguiente formulario:</h3>
                <form name="cForm" id="cForm" method="post" action="">
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
                        <button type="submit" class="submit btn btn--primary full-width">Enviar</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </section>
@endsection