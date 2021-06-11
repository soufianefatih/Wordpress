<?php

/**
 * WordPress Plugin title modifier
 *
 * @package     modifier
 * @author      lamyin
 * @copyright   2021
 *
 * @wordpress-plugin
 * Plugin Name: modifier
 * Plugin URI:
 * Description: modifier le titre de chaque fiche produit
 * Version:     0.0.1
 * Author:      yassine-zouhair
 * Text Domain: wordpress-modify_title
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

add_action('admin_menu', 'modifer_admin');
function modifer_admin()
{
    add_menu_page('modify_title', 'modify_title', 'manage_options', 'modify_title', 'modify_admin_title', 99);
}

function modify_admin_title()
{ 
    global $wpdb;
    $mytestdrafts = array();
    $id = $_GET['id'];
    if ($id) {
        //        echo $mytestdrafts_id;
        include_once("updaterecords.php");
    } else {
              ?>
        <div class="wrap">
            <h4>Modify post title Plugin</h4>
            </br>
            <br />
            <form action="" method="POST">
                <input type="submit" name="title" value="Load all Post" class="button-primary" />

                <br />
                <table class="widefat">
                    <thead>
                        <tr>
                            <th> Post Title</th>
                            <th> Numero </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th> Post Title</th>
                            <th>Numero</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php

                        if (isset($_POST['title'])) {

                            $mytestdrafts = $wpdb->get_results(
                                "
                SELECT ID, post_title
                FROM $wpdb->posts
                WHERE post_type = 'product'
                "
                            );
                            update_option('modify_title_all_posts', $mytestdrafts);
                        } else if (get_option('modify_title_all_posts')) {
                            $mytestdrafts = get_option('modify_title_all_posts');
                        }
                        ?>
                        <?php if ($mytestdrafts != "") {
                            foreach ($mytestdrafts as $mytestdraft) {
                                $id = $mytestdraft->ID;
                                $post_title = $mytestdraft->post_title;

                        ?>
                                <tr>
                                    <td>
                                        <a href="<?= admin_url('admin.php?page=modify_title&id=' . $id . '&title=' . $post_title); ?>"><?= $mytestdraft->post_title; ?></a>
                                    </td>

                                    <td><?= $mytestdraft->ID; ?></td>


                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>
            </form>
        </div>
<?php } }?>