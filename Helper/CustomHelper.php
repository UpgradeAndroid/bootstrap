<?php

class CustomHelper extends Helper {
	public $helpers = array(
		'Html',
		'Layout',
    'Form'
	);

	//Have to subvert the default Croogo menuing to work with bootstrap
	public function nestedLinks( $links, $options = array( ), $depth = 1 ) {

		$_options = array();
		$options = array_merge($_options, $options);

		$output = '';
		foreach ($links AS $link) {
			$linkAttr = array(
				'id' => 'link-' . $link['Link']['id'],
				'rel' => $link['Link']['rel'],
				'target' => $link['Link']['target'],
				'title' => $link['Link']['description'],
				'class' => $link['Link']['class'],
			);

			foreach ($linkAttr AS $attrKey => $attrValue) {
				if ($attrValue == null) {
					unset($linkAttr[$attrKey]);
				}
			}

			// if link is in the format: controller:contacts/action:view
			if (strstr($link['Link']['link'], 'controller:')) {
				$link['Link']['link'] = $this->Layout->linkStringToArray($link['Link']['link']);
			}

			// Remove locale part before comparing links
			if (!empty($this->params['locale'])) {
				$currentUrl = substr($this->_View->request->url, strlen($this->params['locale']));
			} else {
				$currentUrl = $this->_View->request->url;
			}

			if( Router::url( $link[ 'Link' ][ 'link' ] ) == Router::url( '/' . $currentUrl ) ) {
				if( !isset( $linkAttr[ 'class' ] ) ) {
					$linkAttr[ 'class' ] = '';
				}
				$linkAttr[ 'class' ] .= ' ' . $options[ 'selected' ];
			}
			$linkAttr[ 'escape' ] = false;

			$parentTag = '';
			if( isset( $link[ 'children' ] ) && count( $link[ 'children' ] ) > 0 ) {
				$linkAttr[ 'class' ] .= ' dropdown-toggle';
				$linkAttr[ 'data-toggle' ] = 'dropdown';
				$linkOutput = $this->Html->link( $link[ 'Link' ][ 'title' ] . ' <b class="caret"></b>', $link[ 'Link' ][ 'link' ], $linkAttr );
				$linkOutput .= $this->nestedLinks( $link[ 'children' ], $options, $depth + 1, $layout, $html );
				$parentTag = 'dropdown';
			} else {
				$linkOutput = $this->Html->link( $link[ 'Link' ][ 'title' ], $link[ 'Link' ][ 'link' ], $linkAttr );
			}
			$linkOutput = $this->Html->tag( 'li', $linkOutput, array( 'class' => $parentTag ) );
			$output .= $linkOutput;
		}
		if( $output != null ) {
			$tagAttr = $options[ 'tagAttributes' ];
			if( $options[ 'dropdown' ] && $depth == 1 ) {
				$tagAttr[ 'class' ] = $options[ 'dropdownClass' ];
			}
			if( $options[ 'dropdown' ] && $depth > 1 ) {
				$tagAttr[ 'class' ] = " dropdown-menu";
			}
			$output = $this->Html->tag( $options[ 'tag' ], $output, $tagAttr );
		}

		return $output;
	}

  /**
   * @param $name  string form field name, what Form->input would accept
   * @param array $options array options
   * @return string form input html
   */
  public function input($name,$options = array()) {
    $template_cg = '<div class="control-group">%s%s</div>'; // label and cs
    $template_cs = '<div class="controls">%s%s</div>'; // input and help
    $label = '';
    if ( isset($options['label'])  ) {
      if ( $options['label'] !== false ) {
        $label = $this->Form->label($name,$options['label'],$options);
      }
    } else {
      $label = $this->Form->label($name);
    }

    $input = $this->Form->input($name,array_merge($options,array('label'=>false)));
    if ( isset($options['input-prepend']) ) {
      $input = sprintf('<div class="input-prepend"><span class="add-on">%s</span>%s</div>',$options['input-prepend'],$input);
    } else if (isset($options['input-append']) ) {
      $input = sprintf('<div class="input-append">%s<span class="add-on">%s</span>%s</div>',$input,$options['input-append']);
    }
    $help = '';
    if ( isset($options['help']) && !empty($options['help']) ) {
      $help = sprintf('<p class="help-block">%s</p>',$options['help']);
    }
    return sprintf($template_cg,$label,sprintf($template_cs,$input,$help));
  }

  /**
   * @param $label string button label
   * @param $url mixed CakePHP url
   * @param array $options options
   * @return string
   */
  public function button($label,$url,$options=array()) {
    if ( isset($options['icon']) ) {
      $label = sprintf('<i class="icon-%s"></i> %s',$options['icon'],$label);
      $options['escape'] = false;
    }
    if ( isset($options['class']) ) {
      $options['class'] = sprintf("btn %s",$options['class']);
    } else {
      $options['class'] = 'btn';
    }

    return $this->Html->link($label,$url,$options);
  }

}
