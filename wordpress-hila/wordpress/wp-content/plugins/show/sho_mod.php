<?php

if (!current_user_can('manage_options')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

$extend_title_id = $_GET['id'];
extend_title_update_form($extend_title_id);
function extend_title_update_form($extend_title_id)
{
    extend_title_update($extend_title_id);
    global $wpdb;
    if (get_option('extend_title_all_posts')) {
        $extend_title_result = get_option('extend_title_all_posts');
    }
    if ($extend_title_id) {
        foreach ($extend_title_result as $extend_title_cols) {
            $id = $extend_title_cols->ID;
            if ($id == $extend_title_id) {
                $extend_title_title = $_GET['title'];
            }
        }
    }
}


function extend_title_update($extend_title_id)
{
    //update the records
    global $wpdb;

    $table_name = $wpdb->prefix . 'posts';

    $post_title = $_REQUEST['inputposttitle'];

    if(isset($_POST['update']))
    {
        // check to see if any text boxes are empty
        if(empty($post_title))
        {
            //remind users to fill out all the textboxes.
            echo "Please fill out the Post textbox. <br/><br/>";
        }
        else
        {
            $wpdb->update($table_name,
                array(
                    //These names are being pulled from the table.
                    'post_title' => $post_title,
                ),
                array(
                    'id' => $myfirstplugin_id     // where clause
                ) );

            echo "The record was been updated. <br/><br/>";
            $mytestdrafts = $wpdb->get_results(
                "
					SELECT ID, post_title
					FROM $wpdb->posts
					WHERE post_status = 'draft' and post_type = 'post'
					"
            );
            update_option('myfirstplugin_all_draft_posts', $mytestdrafts);
            echo '<script>window.location="admin.php?page=myfirstplugin"</script>';
        }

    } //end of if

} //end of function
?>


    <form action="" method="post">
        <div class="wrap">
            <label>Update the records and click Update button.</label>
            <br /><br />
            <table class="widefat">
                <tr>
                    <th>Post Title</th>
                    <th>Post ID</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><input class="input" type="text" name="inputposttitle" value="<?php echo $myfirstplugin_title;  ?>" /></td>
                    <td><label><?= $id; ?></label></td>
                    <td><button type="submit" name="update" class="button-primary">Update</button></td>
                </tr>
            </table>
        </div>
    </form>

<?php