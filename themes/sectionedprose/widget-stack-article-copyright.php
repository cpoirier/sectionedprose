<?php 
// =============================================================================================
// SectionedProse
//
// [Copyright] Copyright 2011 Chris Poirier
// [License]   Licensed under the Apache License, Version 2.0 (the "License");
//             you may not use this file except in compliance with the License.
//             You may obtain a copy of the License at
//
//                 http://www.apache.org/licenses/LICENSE-2.0
//
//             Unless required by applicable law or agreed to in writing, software
//             distributed under the License is distributed on an "AS IS" BASIS,
//             WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//             See the License for the specific language governing permissions and
//             limitations under the License.
// =============================================================================================
?>

<?php if( $copyright = get_property("copyright") ) { ?>
<ul id="article-copyright-widgets" class="widget-stack body">
   <li class="subscribe">
      <section id="article-copyright" class="widget">
         <header><h1><i><?php echo esc_attr(get_property_context_title());?></i> Copyright © <?php echo $copyright ?></h1></header>
         <?php if( $message = get_property("copyright_message", "") ) { echo markup($message); } ?>
      </section>
   </li>
</ul>
<?php } ?>
