<?php /*
Plugin Name: Custom Author Permalink
Plugin URI: http://dardna.com/custom-author-permalink
Description: <strong>This plugin is deprecated (although still working) and will no longer be maintained. Its functionality has been re-written and improved on <a href="http://wordpress.org/extend/plugins/wp-htaccess-control/">WP htaccess Control</a> which you should be using instead.</strong>
Version: 1.2
Author: dardna
Author URI: http://dardna.com
*/
?><?php
/*  Copyright 2008  António Andrade  (email : dardna@dardna.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?><?php
if (!class_exists("dnaCustomAuthorPermalink")) {
	class dnaCustomAuthorPermalink {
		function dnaCustomAuthorPermalink() { 
			}			
		function admin(){?>
			<div class="wrap"><?php
				switch($_POST['action']){
					case 'Update':
						$dna_cap_author_base = $_POST['dna_cap_author_base'];
						if(ctype_alnum($dna_cap_author_base)){
							update_option('dna_cap_author_base',$dna_cap_author_base);?>
							<div id="message" class="updated">
								<p>Updated</p>
							</div><?php
							}
						else{?>
							<div id="message" class="error">
								<p><strong>Not Updated</strong></p>
							</div><?php
							}						
					default:
						$dna_cap_author_base = get_option('dna_cap_author_base') ? get_option('dna_cap_author_base') : 'author';?>
						<h2>Author Permalink Base</h2>
						<div class="error">
							<p><strong>This plugin is deprecated (although still working) and will no longer be maintained. Its functionality has been re-written and improved on <a href="http://wordpress.org/extend/plugins/wp-htaccess-control/">WP htaccess Control</a> which you should be using instead.</strong></p>
						</div>
						<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
							<p><?php echo bloginfo('home');?>/<input style="border:0;width:100px;background:yellow;font-weight:bold;"name="dna_cap_author_base" type="text" value="<?php echo $dna_cap_author_base;?>"/>/admin</p>
							<input type="hidden" name="action" value="update"/>
							<p class="submit">
								<input type="submit" class="button-primary" name="action" value="Update" />
							</p>
						</form>
						<p><strong>Remember: </strong> if deactivating this plugin, re-submit your permalink options <a href="./options-permalink.php">here</a> afterwards or just reset ('author') the Author Permalink Base here before you go on.</p>
						<p style="clear:both;float:right;font-size:70%">by <a href="http://dardna.com/custom-author-permalink" target="blank_">dardna</a></p><?
					}?>
			</div><?php
			}
		function ConfigureMenu() {
				add_submenu_page("options-general.php","Author Permalink", "Author Permalink", 6, __FILE__, array('dnaCustomAuthorPermalink','admin'));
				}
		function CustomIt(){
			global $wp_rewrite;
			$dna_cap_author_base = get_option('dna_cap_author_base') ? get_option('dna_cap_author_base') : 'author';	
			$wp_rewrite->author_base = $dna_cap_author_base;
			$wp_rewrite->flush_rules();
			}
		function BackToNormal(){
			//Not Working
			/*global $wp_rewrite;
			$wp_rewrite->author_base = 'author';
			$wp_rewrite->flush_rules();*/
			}
		function Activation(){
			// v1.0.1.1 only (nominal fix)
			if(get_option('dnacp_author_base')){
				add_option('dna_cap_author_base',get_option('dnacp_author_base'));
				delete_option('dnacp_author_base');
				}
			}
		}
	} 
if (class_exists("dnaCustomAuthorPermalink")) {
	$dnaCAP = new dnaCustomAuthorPermalink();
	}
if (isset($dnaCAP)) {
	add_action('admin_menu', array($dnaCAP,'ConfigureMenu'));
	add_action('init',array($dnaCAP,'CustomIt'));
	register_activation_hook(__FILE__, array($dnaCAP,'Activation'));
	//register_deactivation_hook(__FILE__, array($dnaCAP,'BackToNormal'));
	}
?>