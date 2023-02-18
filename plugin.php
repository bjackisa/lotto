//Hook to register custom post type for lottery tickets
add_action('init', 'register_lottery_tickets');

//Function to register custom post type for lottery tickets
function register_lottery_tickets() {
    $args = array(
        'label' => __('Lottery Tickets'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'lottery-tickets'),
        'query_var' => true,
        'menu_icon' => 'dashicons-tickets-alt',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
        );
    register_post_type( 'lottery-tickets', $args );
}


//Hook to add custom meta boxes for lottery tickets
add_action('add_meta_boxes', 'add_lottery_ticket_metaboxes');

//Function to add custom meta boxes for lottery tickets
function add_lottery_ticket_metaboxes() {
    add_meta_box('lottery_ticket_date', 'Draw Date', 'lottery_ticket_date', 'lottery-tickets', 'side', 'default');
    add_meta_box('lottery_ticket_number', 'Ticket Number', 'lottery_ticket_number', 'lottery-tickets', 'side', 'default');
    add_meta_box('lottery_ticket_price', 'Ticket Price', 'lottery_ticket_price', 'lottery-tickets', 'side', 'default');
}

//Function to display meta box for lottery ticket draw date
function lottery_ticket_date() {
    global $post;
    $custom = get_post_custom($post->ID);
    $date = $custom["lottery_ticket_draw_date"][0];
    ?>
    <label>Draw Date:</label>
    <input name="lottery_ticket_draw_date" value="<?php echo $date; ?>" />
    <?php
}

//Function to display meta box for lottery ticket number
function lottery_ticket_number() {
    global $post;
    $custom = get_post_custom($post->ID);
    $number = $custom["lottery_ticket_number"][0];
    ?>
    <label>Ticket Number:</label>
    <input name="lottery_ticket_number" value="<?php echo $number; ?>" />
    <?php
}

//Function to display meta box for lottery ticket price
function lottery_ticket_price() {
    global $post;
    $custom = get_post_custom($post->ID);
    $price = $custom["lottery_ticket_price"][0];
    ?>
    <label>Ticket Price:</label>
    <input name="lottery_ticket_price" value="<?php echo $price; ?>" />
    <?php
}

//Hook to save custom meta boxes for lottery tickets
add_action('save_post', 'save_lottery_ticket_metaboxes');

//Function to save custom meta boxes for lottery tickets
function save_lottery_ticket_metaboxes() {
    global $post;
    update_post_meta($post->ID, "lottery_ticket_draw_date", $_POST["lottery_ticket_draw_date"]);
    update_post_meta($post->ID, "lottery_ticket_number", $_POST["lottery_ticket_number"]);
    update_post_meta($post->ID, "lottery_ticket_price", $_POST["lottery_ticket_price"]);
}

//Hook to register shortcode for lottery ticket purchase
add_shortcode('lottery_ticket_purchase', 'lottery_ticket_purchase_shortcode');

//Function to register shortcode for lottery ticket purchase
function lottery_ticket_purchase_shortcode() {
    ob_start();
    ?>
    <form action="" method="post">
        <label>Lottery Ticket Number:</label>
        <input type="text" name="lottery_ticket_number" />
        <input type="submit" name="submit" value="Purchase Ticket" />
    </form>
    <?php
    return ob_get_clean();
}

//Hook to process lottery ticket purchase
add_action('parse_request', 'process_lottery_ticket_purchase');

//Function to process lottery ticket purchase
function process_lottery_ticket_purchase() {
    if(isset($_POST['submit']) && $_POST['submit'] == 'Purchase Ticket') {
        //validate ticket number
        $ticket_number = $_POST['lottery_ticket_number'];
        //look up ticket in database
        //if ticket exists, process payment
        //if payment is successful, confirm purchase
    }
}
