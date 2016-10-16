<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jticketing
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<style>
.art-title{color:#231f20; font-size:20px; font-weight:700;}
.artist-data{width:100%; padding-bottom: 25px;}
.artst-pic{width:33%;position: relative;}
.artst-pic span a{color: #fff; font-size: 16px; display: none;}
.artst-pic span.artst-like{position: absolute; left: 11%; bottom: 10px;}
.artst-pic span.artst-share{position: absolute; left:46%; bottom: 10px;}
.artst-pic span.artst-plus{position: absolute; right: 9%; bottom: 10px;}
.artst-prfle{width:63%;}
.artst-prfle span.artst-sub{font-size:15px; color:#bbb; float:left; width:100%; font-weight:normal; padding:5px 0;}
.artst-prfle span.artst-sub span.byname{font-weight:700; color:#aaa;}
.artst-prfle span.artst-sub span.daysago{float:right; font-size:12px;}
.counter-tab{float: left; width: 100%; padding-top: 45px;}
.counter-tab div{float: left; width: 33%; color: #aaa; font-size: 12px;}
.bot-links{float: left; width: 100%; padding-top: 10px;}
.bot-links a{display: inline-block; padding: 5px; background: #ccc; font-size: 12px; margin-bottom: 5px; color: #9c9c9c; text-decoration:none;}
span.play-icon{position: absolute; left: 31%; top: 32%; display: none;}
.artst-pic:hover img.play-icon, .artst-pic:hover span a{display: block; } 

</style>
<div class="container">
    <div class="row">
                <div class="col-md-8">
                	<div class="artist-data pull-left">
                    	<div class="artst-pic pull-left">
                    		<span class="artst-like"><a href="#"><i class="glyphicon glyphicon-heart-empty"></i></a></span>
                    		<span class="artst-share"><a href="#"><i class="glyphicon glyphicon-share"></i></a></span>
                    		<span class="artst-plus"><a href="#"><i class="glyphicon glyphicon-plus-sign"></i></a></span>
                    		<a href="#">
                    			<img src="http://placehold.it/122x122" alt="" class="img-responsive" />
                    		</a>
                    	</div>
                    	
                        <div class="artst-prfle pull-right">
                        	<div class="art-title">
                            	<?php echo $this->item->title; ?>
                                <span class="artst-sub"><?php echo JHTML::date($this->item->event_start); ?></span> 
                                <span class="artst-sub">By <span class="byname"><?php echo JFactory::getUser($this->item->created_by)->name; ?></span></span> 
                            </div>
                            <div>
								<?php echo $this->item->description; ?>
                            </div>
                            <div class="counter-tab">
                            	<div class="counter_comnt"><i class="glyphicon glyphicon-comment"></i> 359</div>
                            	<div class="counter_ply"><i class="glyphicon glyphicon-play"></i> 1312</div>
                            	<div class="counter_like"><i class="glyphicon glyphicon-heart"></i> 2256</div>
                            </div>
                        </div>

                    </div>
                </div>
</div>
</div>
