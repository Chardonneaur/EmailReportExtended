<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\EmailReportExtended;

use Piwik\Piwik;
use Piwik\Plugins\CoreAdminHome\Controller as CoreAdminController;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;

/**
 * Defines Settings for EmailReportExtended.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $metric;

    protected function init()
    {
        $isWritable = Piwik::hasUserSuperUserAccess() && CoreAdminController::isGeneralSettingsAdminEnabled();
        $this->setting = $this->createMetricSetting();
        $this->setting->setIsWritableByCurrentUser($isWritable);


    }

    private function createMetricSetting()
    {
        return $this->makeSettingManagedInConfigOnly("General",'scheduled_reports_truncate', $default = '23', FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = 'Number of rows to display';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'Define the number of rows which will be displayed within the email report. This setting override the config.ini.php file. The higher this number is, the bigger your email report will be.';
            $field->validators[] = new NotEmpty();
        });
    }
}
