<?php
class TemplateSettings
{
    private static $settings = [
        'DIR_LAYOUT' => 'http://snapsects.com',
        'TEMPLATE_CONTENT' => '',
        'TEMPLATE_TITLE' => '',
        'SITE_URL' => 'http://www.snapsects.com/',//'http://www.snapsects.com/site/'
    ];
    
    static public function getSettings() {
        return self::$settings;
    }
    
    static public function getSiteUrl()
    {
        return self::$settings['SITE_URL'];
    }

}
