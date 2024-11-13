<style>
    .wpcc-wrap > header {
        margin-left: -20px;
        min-height: 74px;
        background-color: #FFFFFF;
        padding: 15px 20px 7px;
    }

    .wpcc-logo-container {
        float: left;
        width: 33%;
        height: 64px;
    }

    .wpcc-logo-container > h1 {
        margin-top: 13px;
        margin-bottom: 6px;
    }

    .wpcc-logo {
        float: left;
        padding-right: 15px;
        max-height:64px;
    }

    .wpcc-slogan {
        font-size: 15px;
        font-weight: 500;
        color: #5f5f5f;
        margin-left: 26px;
    }

    .wpcc-header-content {
        text-align: right;
    }

    .wpcc-container {
        padding-top:15px;
    }

    .wpcc-tab-container {
        padding: 15px;
        min-width: 255px;
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        border: 1px solid #ccd0d4;
    }

    .wpcc-tab-container h3:nth-child(1) {
        margin-top: 0;
    }

    .wpcc-tab-container .submit {
        margin-top: 12px;
        padding: 0;
    }

    .nav-tab-wrapper, .wrap h2.nav-tab-wrapper, h1.nav-tab-wrapper {
        border-bottom: 0;
    }

    .nav-tab-active, .nav-tab-active:focus, .nav-tab-active:focus:active, .nav-tab-active:hover {
        border-top: 2px solid #0272aa;
        border-bottom: 0;
        color: #0272aa;
        background: #FFFFFF;
        box-shadow: 0 0 1px rgba(0,0,0,0.04);
    }

    .wpcc-formgroup-container {
        padding: 20px 15px 10px;
        background-color: #f2f4f5;
        border-radius: 6px;
    }

    .wpcc-field-container > label {
        font-weight: bold;
    }

    .wpcc-field-container input[type="checkbox"] {
        margin-top: 1px;
    }

    .wpcc-help-text {
        display: block;
        padding: 0.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
        font-style: italic;
        border: 1px solid #eee;
        border-left-width: .25rem;
        border-radius: .25rem;
        border-left-color: #5bc0de;
        background-color: #e7f3f9;
    }
</style>

<div class="wpcc-wrap">
    <header class="wpcc-header">
        <div class="wpcc-logo-container">
            <img src="<?= WPCC_PLUGIN_URL . 'resources/themes/2020/images/avatars/caveo.png' ?>" class="wpcc-logo">

            <h1>WP Caveo Cache</h1>
            <span class="wpcc-slogan">- #hostpersoonlijk -</span>
        </div>
        <div class="wpcc-header-content">
            <?php // todo: Evt een menu of link naar de website van caveo? ?>
        </div>
    </header>

    <div class="wpcc-container">
        @content
    </div>
</div>
