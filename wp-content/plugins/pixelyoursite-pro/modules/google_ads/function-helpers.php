<?php

namespace PixelYourSite\Ads\Helpers;

use PixelYourSite;
use function PixelYourSite\GATags;
use function PixelYourSite\wooGetOrderIdFromRequest;
use function PixelYourSite\isWPMLActive;
use function PixelYourSite\getWPMLProductId;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function getWooFullItemId( $item_id ) {

    if(isWPMLActive()) {
        $item_id = getWPMLProductId($item_id, PixelYourSite\GATags());
    }
    if ( PixelYourSite\GATags()->getOption( 'woo_content_id' ) == 'product_sku' ) {
        $product = wc_get_product( $item_id );
        if ( $product->is_type( 'variation' ) ) {
            $content_id = $product->get_sku();
            if ( empty( $content_id ) ) {
                $parent_id = $product->get_parent_id();
                $parent_product = wc_get_product( $parent_id );
                $content_id = $parent_product->get_sku();
                if ( empty( $content_id ) ) {
                    $content_id = $item_id;
                }
            }
        } else {
            $content_id = $product->get_sku();
            if ( empty( $content_id ) ) {
                $content_id = $item_id;
            }
        }
    } else {
        $content_id = $item_id;
    }

	$prefix = PixelYourSite\GATags()->getOption( 'woo_content_id_prefix' );
	$suffix = PixelYourSite\GATags()->getOption( 'woo_content_id_suffix' );

    if(!empty($content_id)){
        return trim( $prefix ) . $content_id . trim( $suffix );
    }
	
	return '';
}

function getWooEventCartItemId( $product ) {

    if ( PixelYourSite\GATags()->getOption( 'woo_variable_as_simple' ) && isset( $product['parent_id'] ) && $product['parent_id'] !== 0 ) {
        return $product['parent_id'];
    } else {
        return $product['product_id'];
    }

}

/**
 * @deprecated use getWooEventCartItemId
 * @param $item
 * @return mixed
 */
function getWooCartItemId( $item ) {

    if ( ! PixelYourSite\GATags()->getOption( 'woo_variable_as_simple' ) && isset( $item['variation_id'] ) && $item['variation_id'] !== 0 ) {
        $product_id = $item['variation_id'];
    } else {
        $product_id = $item['product_id'];
    }

    return $product_id;
}

function getWooProductDataId( $item ) {
    if($item['type'] == 'variation'
        && PixelYourSite\GATags()->getOption( 'woo_variable_as_simple' )
    ) {
        $product_id = $item['parent_id'];
    }else {
        $product_id = $item['id'];
    }

    return $product_id;

}

/**
 * Render conversion label and key pair for each Google Tag ID. When no ID is set, dummy UI will be rendered.
 *
 * @param string $eventKey
 */
function renderConversionLabelInputs($eventKey) {

    $ids = PixelYourSite\Ads()->getAllPixels(false);
    $count = count($ids);
    $conversion_labels = (array) PixelYourSite\Ads()->getOption("{$eventKey}_conversion_labels");

    if ($count === 0) : ?>

        <div class="row mt-1 mb-2">
            <div class="col-11 col-offset-left form-inline">
                <label>Add conversion label </label>
                <input type="text" disabled="disabled" placeholder="Enter conversion label" class="form-control">
                <label> for </label>
                <input type="text" disabled="disabled" placeholder="Google Ads Tag not found" class="form-control">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-link" role="button" data-toggle="pys-popover" data-trigger="focus"
                        data-placement="right" data-popover_id="google_ads_conversion_label" data-original-title=""
                        title="">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                </button>
            </div>
        </div>

    <?php else : ?>

        <?php foreach ($ids as $key => $id) : ?>

            <?php

            $conversion_label_input_name = "pys[google_ads][{$eventKey}_conversion_labels][{$id}]";
            $conversion_label_input_value = isset($conversion_labels[$id]) ? $conversion_labels[$id] : null;

            ?>

            <div class="row mt-1 mb-2">
                <div class="col-11 col-offset-left form-inline">
                    <label>Add conversion label </label>
                    <input type="text" class="form-control" placeholder="Enter conversion label"
                           name="<?php esc_attr_e($conversion_label_input_name); ?>"
                           value="<?php esc_attr_e($conversion_label_input_value); ?>">
                    <label> for <?php esc_attr_e($id); ?></label>
                </div>

                <?php if ($key === 0) : ?>

                    <div class="col-1">
                        <button type="button" class="btn btn-link" role="button" data-toggle="pys-popover"
                                data-trigger="focus" data-placement="right"
                                data-popover_id="google_ads_conversion_label" data-original-title="" title="">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </button>
                    </div>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    <?php endif;
}

function getConversionIDs($eventKey, $ids = []) {

    // Conversion labels for specified event
    $labels = PixelYourSite\Ads()->getOption($eventKey . '_conversion_labels');
	$type_conversion_label = PixelYourSite\Ads()->getOption($eventKey . '_conversion_track');
    $tag_ids = PixelYourSite\Ads()->getAllPixels();

    $conversion_ids = [];

    if($eventKey == "woo_purchase") {
        $order_id = wooGetOrderIdFromRequest();
	    $order    = wc_get_order( $order_id );
        if($order) {
            foreach ( $order->get_items( 'line_item' ) as $line_item ) {

                $product_id = getWooCartItemId($line_item);
                $product = wc_get_product($product_id);

                if (!$product || !$product->meta_exists('_pys_conversion_label_settings') ) continue;
                $meta = $product->get_meta("_pys_conversion_label_settings",true);

                if(is_array($meta) && $meta['enable'] && (empty($ids) || in_array($meta['id'],$ids))) {
                    $conversion_ids[] = $meta['id'] . '/' . $meta['label'];
                }
            }
        }
    }


    // If no labels specified raw Google Ads Tag IDs will be used


    foreach ($tag_ids as $key => $tag_id) {
        if (!empty($labels) && isset($labels[$tag_id]) && (empty($ids) || in_array($tag_id,$ids))) {
            $conversion_ids[] = $tag_id . '/' . $labels[$tag_id];
        }
        elseif ($type_conversion_label != 'conversion' && (empty($ids) || in_array($tag_id,$ids))){
	        $conversion_ids[] = $tag_id;
        }
    }

    return $conversion_ids;
}

function sanitizeTagIDs($ids) {

    if (!is_array($ids)) {
        $ids = (array)$ids;
    }

    foreach ($ids as $key => $id) {
        $ids[$key] = preg_replace('/[^0-9a-zA-z_\-\/]/', '', $id);
    }

    return $ids;
}

/**
 * EASY DIGITAL DOWNLOADS
 */

function getEddDownloadContentId( $download_id ) {

    if ( PixelYourSite\GATags()->getOption( 'edd_content_id' ) == 'download_sku' ) {
        $content_id = get_post_meta( $download_id, 'edd_sku', true );
    } else {
        $content_id = $download_id;
    }

    $prefix = PixelYourSite\GATags()->getOption( 'edd_content_id_prefix' );
    $suffix = PixelYourSite\GATags()->getOption( 'edd_content_id_suffix' );

    return $prefix . $content_id . $suffix;

}