<?php
/**
 * WordPress Plugin title
 *
 * @package     extend title
 * @author      hamza-soufian
 * @copyright   2021
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: extend title
 * Plugin URI:
 * Description: modifier le titre de chaque fiche produit
 * Version:     0.0.1
 * Author:      hamza-soufian
 * Text Domain: wordpress-extend_title
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

add_action('admin_menu', 'extend_title_admin_action');
function extend_title_admin_action()
{
    add_options_page('extend_title', 'extend_title', 'manage_options', __FILE__, 'extend_title_admin');
}

function extend_title_admin()
{
    global $wpdb;
    $mytestdrafts = array();
    // $mytestdrafts_id = $_GET['id'];
    if ($mytestdrafts_id) {
        echo $mytestdrafts_id;
//        include_once("updaterecords.php");
    } else {
        ?>
        <div class="wrap">
            <h4>Edit post title Plugin</h4>
            </br>
            <br/>
            <form action="" method="POST">
                <input type="submit" name="search_all_post" value="Load all Post" class="button-primary"/>

                <br/>
                <table class="widefat">
                    <thead>
                    <tr>
                        <th> Post Title</th>
                        <th> Post ID</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th> Post Title</th>
                        <th> Post ID</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php

                    if (isset($_POST['search_all_post'])) {

                        $mytestdrafts = $wpdb->get_results(
                            "
                SELECT ID, post_title
                FROM $wpdb->posts
                WHERE post_type = 'product'
                "
                        );
                        update_option('myfirstplugin_all_draft_posts', $mytestdrafts);
                    } else if (get_option('myfirstplugin_all_draft_posts')) {
                        $mytestdrafts = get_option('myfirstplugin_all_draft_posts');
                    }
                    ?>
                    <?php if ($mytestdrafts != "") {
                        foreach ($mytestdrafts as $mytestdraft) {
                            $id = $mytestdraft->ID;
                            $post_title = $mytestdraft->post_title;

                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=extend_title&id=' . $id . '&title=' . $post_title); ?>"><?php echo $mytestdraft->post_title; ?></a>
                                </td>

                                <td><?php echo $mytestdraft->ID; ?></td>


                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>

                </table>
            </form>
        </div>
        <?php


    }
}

?>



