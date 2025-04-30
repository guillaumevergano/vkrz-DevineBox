<?php
// Notion API configuration
define('NOTION_API_KEY', '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');
define('NOTION_DATABASE_ID', '1db31dc9531780cfa332de84589a4117');

// Function to get Notion page data
function get_notion_page_data($page_id) {
    $response = wp_remote_get(
        'https://api.notion.com/v1/pages/' . $page_id,
        array(
            'headers' => array(
                'Authorization' => 'Bearer ' . NOTION_API_KEY,
                'Notion-Version' => '2022-06-28'
            )
        )
    );

    if (is_wp_error($response)) {
        return array(
            'success' => false,
            'error' => $response->get_error_message()
        );
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['error'])) {
        return array(
            'success' => false,
            'error' => $data['message']
        );
    }

    return array(
        'success' => true,
        'data' => $data
    );
}

// AJAX handler for backward compatibility
function handle_notion_page_request() {
    if (!wp_doing_ajax()) return;

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'notion_api_nonce')) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    if (!isset($_POST['page_id'])) {
        wp_send_json_error('Missing page ID');
        return;
    }

    $page_id = sanitize_text_field($_POST['page_id']);
    $result = get_notion_page_data($page_id);

    if ($result['success']) {
        wp_send_json_success($result['data']);
    } else {
        wp_send_json_error($result['error']);
    }
}

add_action('wp_ajax_get_notion_page', 'handle_notion_page_request');
add_action('wp_ajax_nopriv_get_notion_page', 'handle_notion_page_request');