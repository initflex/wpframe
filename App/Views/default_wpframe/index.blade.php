<div class="wpf-flex-container-1 wpf-spacing">
    <img class="wpf-logo-intro" src="{{ $GLOBALS['WPFP_CONFIG']['assets_url'] .'images/logos/favicon-96x96.png' }}" alt="">
    <div class="wpf-text-center">
        <h1>{{ $GLOBALS['WPFP_CONFIG']['developer_app'] }} - WPFrame</h1>
        <p>Open Source Project - <a href="https://initflex.com/" target="_blank">Initflex - WPFrame</a></p>
    </div>
    
</div>
<div class="wpf-flex-container-2 wpf-spacing">
    <div class="wpf-box-container">
        <h1>Hello, {{ ucfirst($name) }} - Welcome!</h1>
        <p>Thanks for using WPFrame. For usage documentation you can read it through the official Initflex website via the button below.</p>
        <div>
            <a href="{{ $GLOBALS['WPFP_CONFIG']['developer_link'] }}" target="_blank">
                <button class="wpf-button-primary">Documentation</button>
            </a>
            
        </div>
    </div>
    <div class="wpf-box-container">
        <h1>System Info</h1>
        <p>PHP Version: {{ @PHP_VERSION }}</p>
        <p>System: {{ @php_uname() }}</p>
    </div>
</div>

<div class="wpf-flex-container-1 wpf-spacing">
    <div class="wpf-box-container">
        <h1>Others</h1>
        <p>Attention!
            WPFrame uses several libraries and helpers from third parties such as Laravel, CodeIgniter, Whoops, CakePHP and Others. You can read usage documentation and usage references from their respective official websites.
            We also thank third parties for making them open source licenses.
        </p>
    </div>
</div>