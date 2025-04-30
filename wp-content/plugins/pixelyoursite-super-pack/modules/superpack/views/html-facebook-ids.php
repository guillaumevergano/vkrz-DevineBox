<?php

namespace PixelYourSite\SuperPack;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use PixelYourSite;

?>

    <?php
$isWpmlActive = isWPMLActive();
if ($isWpmlActive) {
    $languageCodes = array_keys(apply_filters('wpml_active_languages', null, null));
}
$pixelsInfo = PixelYourSite\SuperPack()->getFbAdditionalPixel();

foreach ($pixelsInfo as $index => $pixelInfo) : ?>
    <div class="plate mt-3 pt-4 pb-3 pixel_info">
        <?php PixelYourSite\SuperPack()->render_text_input_array_item('fb_ext_pixel_id',"", $index,true); ?>
        <div class="row">
            <div class="col-11">
                <div class='custom-switch '>
                    <input type="checkbox" value="1" <?php checked($pixelInfo->isEnable, true); ?>
                           id="pixel_facebook_is_enable_<?=$index?>" class="custom-switch-input is_enable">
                    <label class="custom-switch-btn" for="pixel_facebook_is_enable_<?=$index?>"></label>
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-sm remove-row">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <p>
                    <input type="text" value="<?= $pixelInfo->pixel ?>"
                           placeholder="Meta Pixel (formerly Facebook Pixel) ID" class='form-control pixel_id'/>
                </p>
                <p>
                 <textarea type="text"
                           placeholder="Api token"
                           class="form-control pixel_ext"
                           data-ext="api_token"><?= !empty($pixelInfo->extensions['api_token']) ? $pixelInfo->extensions['api_token'] : "" ?></textarea>
                </p>
                <p>
                    <input type="text" data-ext="api_code" value="<?= !empty($pixelInfo->extensions['api_code']) ?  $pixelInfo->extensions['api_code'] : "" ?>"
                           placeholder="Code" class='form-control pixel_ext'>
                </p>
                <p>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="1"
                               class="custom-control-input is_fire_signal" <?php checked($pixelInfo->isFireForSignal, true); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Fire the active automated events for this pixel</span>
                    </label>
                </p>

                <?php if (PixelYourSite\isWooCommerceActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input is_fire_woo" <?php checked($pixelInfo->isFireForWoo, true); ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the WooCommerce events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <?php if (PixelYourSite\isEddActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   class="custom-control-input is_fire_edd" <?php checked($pixelInfo->isFireForEdd, true); ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the Easy Digital Downloads events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <p>
                    <strong>Display conditions:</strong>
                    <div class="row align-items-center mb-3" bis_skin_checked="1">
                        <div class="col-12 form-inline" bis_skin_checked="1">
                            <label>Logic: </label>
                            <select class="form-control-sm logic_conditional_track" id="facebook_logic_conditional_track_<?=$index?>">
                                <option value="" disabled selected>Please, select...</option>
                                <?php
                                $track_options = array(
                                    'track' => 'Track',
                                    'dont_track' => 'Don\'t track',
                                );
                                foreach ( $track_options as $option_key => $option_value ) : ?>
                                    <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $pixelInfo->logicConditionalTrack ); ?> ><?php echo esc_attr( $option_value ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <?php SpPixelCondition()->renderHtml($pixelInfo->displayConditions) ?>
                </p>
                <hr>

                <?php if(PixelYourSite\SuperPack()->getOption('enable_hide_this_tag_by_url')) : ?>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <div class='custom-switch '>
                                <input type="checkbox" value="1" <?php checked($pixelInfo->isHideByUrl, true); ?>
                                       id="pixel_facebook_is_hide_url_<?=$index?>" class="custom-switch-input is-hide-url">
                                <label class="custom-switch-btn" for="pixel_facebook_is_hide_url_<?=$index?>"></label>
                            </div>
                            <h4 class="switcher-label">Hide this tag if the URL includes</h4>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <h4 class="label">Hide this tag if the page URL any of these values. The tag will not fire when any of these values are present in the URL, or URL parameters:</h4>
                            <select class="form-control pys-condition-pysselect2 hide-conditions-url" id="pixel_facebook_hide_url_conditions_<?=$index?>" style="width: 100%;"
                                    multiple>

                                <?php foreach ( $pixelInfo->hideConditionByUrl as $tag ) : ?>
                                    <option  value="<?php echo esc_attr( $tag ); ?>" selected locked="locked">
                                        <?php echo esc_attr( $tag ); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <hr>
                <?php endif; ?>
                <?php if(PixelYourSite\SuperPack()->getOption('enable_hide_this_tag_by_tags')) : ?>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <div class='custom-switch '>
                                <input type="checkbox" value="1" <?php checked($pixelInfo->isHide, true); ?>
                                       id="pixel_facebook_is_hide_<?=$index?>" class="custom-switch-input is-hide">
                                <label class="custom-switch-btn" for="pixel_facebook_is_hide_<?=$index?>"></label>
                            </div>
                            <h4 class="switcher-label">Hide this tag if the landing URL includes these URL tags</h4>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <h4 class="label">Hide this tag if the <b>landing page URL</b> includes any of these values. The tag will not fire on any pages in the session. URL parameters are considered.</h4>
                            <select class="form-control pys-condition-pysselect2 hide-conditions" id="pixel_facebook_hide_conditions_<?=$index?>" style="width: 100%;"
                                    multiple>

                                <?php foreach ( $pixelInfo->hideCondition as $tag ) : ?>
                                    <option  value="<?php echo esc_attr( $tag ); ?>" selected locked="locked">
                                        <?php echo esc_attr( $tag ); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                            <small>
                                Use this format: param_name=value or param_name<br>
                                Example: brand=Apple, brand.
                            </small>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12 flex-input-block" >
                            <h4 class="label">Hide for:</h4>
                            <input type="number"
                                   id="pixel_facebook_hide_time"
                                   value="<?php echo isset($pixelInfo->hideTime) && !empty($pixelInfo->hideTime) ? $pixelInfo->hideTime : 24 ?>"
                                   min="0" class="form-control hide-time"
                                   max="720"
                                   step="0.01"
                            >
                            <span>Hours</span>
                        </div>

                    </div>
                    <hr>
                <?php endif; ?>
                <?php
                if($isWpmlActive && !empty($languageCodes)) {
                    $active = $pixelInfo->wpmlActiveLang;
                    if($active == null && !is_array($active)) {
                        $active = $languageCodes;
                    }
                    printLangList($active, $languageCodes);
                }

                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    <div class="plate mt-3 pt-4 pb-3 pixel_info" id="pys_superpack_facebook_pixel_id" style="display: none;">
        <input type="hidden" name="pys[superpack][fb_ext_pixel_id][]"  value="" placeholder="0" class="form-control">
        <div class="row">
            <div class="col-11">
                <div class='custom-switch '>
                    <input type="checkbox" value="1" checked
                           id="pixel_facebook_is_enable" class="custom-switch-input is_enable">
                    <label class="custom-switch-btn" for="pixel_facebook_is_enable"></label>
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-sm remove-row">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <p>
                    <input type="text" value=""
                           placeholder="Meta Pixel (formerly Facebook Pixel) ID" class='form-control pixel_id'/>
                </p>
                <p>
                 <textarea type="text"
                           placeholder="Api token"
                           class="form-control pixel_ext"
                           data-ext="api_token"></textarea>
                </p>
                <p>
                    <input type="text" data-ext="api_code" value=""
                           placeholder="Code" class='form-control pixel_ext'>
                </p>
                <p>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" class="custom-control-input is_fire_signal" checked >
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Fire the active automated events for this pixel</span>
                    </label>
                </p>

                <?php if (PixelYourSite\isWooCommerceActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input is_fire_woo" checked>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the WooCommerce events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <?php if (PixelYourSite\isEddActive()) : ?>
                    <p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input is_fire_edd" checked>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Fire the Easy Digital Downloads events for this pixel</span>
                        </label>
                    </p>
                <?php endif; ?>
                <p>
                    <strong>Display conditions:</strong>
                    <div class="row align-items-center mb-3" bis_skin_checked="1">
                        <div class="col-12 form-inline" bis_skin_checked="1">
                            <label>Logic: </label>
                            <select class="form-control-sm logic_conditional_track" id="facebook_logic_conditional_track">
                                <option value="" disabled selected>Please, select...</option>
                                <?php
                                $track_options = array(
                                    'track' => 'Track',
                                    'dont_track' => 'Don\'t track',
                                );
                                foreach ( $track_options as $option_key => $option_value ) : ?>
                                    <option value="<?php echo esc_attr( $option_key ); ?>"><?php echo esc_attr( $option_value ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <?php SpPixelCondition()->renderHtml() ?>
                </p>
                <hr>

                <?php if(PixelYourSite\SuperPack()->getOption('enable_hide_this_tag_by_url')) : ?>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <div class='custom-switch '>
                                <input type="checkbox" value="1"
                                       id="pixel_facebook_is_hide_url" class="custom-switch-input is-hide-url">
                                <label class="custom-switch-btn" for="pixel_facebook_is_hide_url"></label>
                            </div>
                            <h4 class="switcher-label">Hide this tag if the URL includes</h4>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <h4 class="label">Hide this tag if the page URL any of these values. The tag will not fire when any of these values are present in the URL, or URL parameters:</h4>
                            <select class="form-control pys-condition-pysselect2 hide-conditions-url" id="pixel_facebook_hide_url_conditions" style="width: 100%;" multiple></select>
                        </div>
                    </div>
                    <hr>
                <?php endif; ?>
                <?php if(PixelYourSite\SuperPack()->getOption('enable_hide_this_tag_by_tags')) : ?>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <div class='custom-switch '>
                                <input type="checkbox" value="1"
                                       id="pixel_facebook_is_hide" class="custom-switch-input is-hide">
                                <label class="custom-switch-btn" for="pixel_facebook_is_hide"></label>
                            </div>
                            <h4 class="switcher-label">Hide this tag if the landing URL includes these URL tags</h4>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12">
                            <h4 class="label">Hide this tag if the <b>landing page URL</b> includes any of these values. The tag will not fire on any pages in the session. URL parameters are considered.</h4>
                            <select class="form-control pys-condition-pysselect2 hide-conditions" id="pixel_facebook_hide_conditions" style="width: 100%;" multiple> </select>                       </select>
                            <small>
                                Use this format: param_name=value or param_name<br>
                                Example: brand=Apple, brand.
                            </small>
                        </div>
                    </div>
                    <div class="row align-items-center pb-3">
                        <div class="col-12 flex-input-block" >
                            <h4 class="label">Hide for:</h4>
                            <input type="number"
                                   id="pixel_facebook_hide_time"
                                   value="24"
                                   min="0" class="form-control hide-time"
                                   max="720"
                                   step="0.01"
                            >
                            <span>Hours</span>
                        </div>
                    </div>
                    <hr>
                <?php endif; ?>
                <?php if ($isWpmlActive && !empty($languageCodes)) {
                    printLangList($languageCodes, $languageCodes );
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row my-3">

        <div class="col-12">
            <button class="btn btn-sm btn-primary" type="button"
                    id="pys_superpack_add_facebook_pixel_id">
                Add Extra Meta Pixel (formerly Facebook Pixel) ID
            </button>
        </div>
    </div>

<?php
