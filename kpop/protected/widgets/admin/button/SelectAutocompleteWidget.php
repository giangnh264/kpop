<?php
class SelectAutocompleteWidget extends CWidget
{
	public $id = 'combobox';
	public $name = '';
	public $select = '';
	public $data = array();
	public $htmlOptions = array();
	public function run()
	{
		$this->htmlOptions = CMap::mergeArray($this->htmlOptions, array('id'=>$this->id));
		$assetPath = Yii::getPathOfAlias('application.widgets.admin.button.assets');
		$assetsUrl = Yii::app()->getAssetManager()->publish($assetPath,false,1,YII_DEBUG);
		Yii::app()->getClientScript()->registerCssFile($assetsUrl.'/css/style.css');
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,'
				(function( $ ) {
				    $.widget( "custom.combobox", {
				      _create: function() {
				        this.wrapper = $( "<span style=\"position: relative;display: inline-block\">" )
				          .addClass( "custom-combobox" )
				          .insertAfter( this.element );
				 
				        this.element.hide();
				        this._createAutocomplete();
				        this._createShowAllButton();
				      },
				 
				      _createAutocomplete: function() {
				        var selected = this.element.children( ":selected" ),
				          value = selected.val() ? selected.text() : "";
				 
				        this.input = $( "<input>" )
				          .appendTo( this.wrapper )
				          .val( value )
				          .attr( "title", "" )
				          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
				          .autocomplete({
				            delay: 0,
				            minLength: 0,
				            source: $.proxy( this, "_source" )
				          })
				          .tooltip({
				            tooltipClass: "ui-state-highlight"
				          });
				 
				        this._on( this.input, {
				          autocompleteselect: function( event, ui ) {
				            ui.item.option.selected = true;
				            this._trigger( "select", event, {
				              item: ui.item.option
				            });
				          },
				 
				          autocompletechange: "_removeIfInvalid"
				        });
				      },
				 
				      _createShowAllButton: function() {
				        var input = this.input,
				          wasOpen = false;
				 
				        $( "<a>" )
				          .attr( "tabIndex", -1 )
				          .attr( "title", "Show All Items" )
				          //.tooltip()
				          .appendTo( this.wrapper )
				          .button({
				            icons: {
				              primary: "ui-icon-triangle-1-s"
				            },
				            text: false
				          })
				          .removeClass( "ui-corner-all" )
				          .addClass( "custom-combobox-toggle ui-corner-right" )
				          .mousedown(function() {
				            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
				          })
				          .click(function() {
				            input.focus();
				 
				            // Close if already visible
				            if ( wasOpen ) {
				              return;
				            }
				 
				            // Pass empty string as value to search for, displaying all results
				            input.autocomplete( "search", "" );
				          });
				      },
				 
				      _source: function( request, response ) {
				        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				        response( this.element.children( "option" ).map(function() {
				          var text = $( this ).text();
				          if ( this.value && ( !request.term || matcher.test(text) ) )
				            return {
				              label: text,
				              value: text,
				              option: this
				            };
				        }) );
				      },
				 
				      _removeIfInvalid: function( event, ui ) {
				 
				        // Selected an item, nothing to do
				        if ( ui.item ) {
				          return;
				        }
				 
				        // Search for a match (case-insensitive)
				        var value = this.input.val(),
				          valueLowerCase = value.toLowerCase(),
				          valid = false;
				        this.element.children( "option" ).each(function() {
				          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
				            this.selected = valid = true;
				            return false;
				          }
				        });
				 
				        // Found a match, nothing to do
				        if ( valid ) {
				          return;
				        }
				 
				        // Remove invalid value
				        this.input
				          .val( "" )
				          .attr( "title", value + " didn\'t match any item" )
				          .tooltip( "open" );
				        this.element.val( "" );
				        this._delay(function() {
				          this.input.tooltip( "close" ).attr( "title", "" );
				        }, 2500 );
				        this.input.autocomplete( "instance" ).term = "";
				      },
				 
				      _destroy: function() {
				        this.wrapper.remove();
				        this.element.show();
				      }
				    });
				  })( $ );
				 
				  $(function() {
				    $( "#'.$this->id.'" ).combobox();
				    $( "#toggle" ).click(function() {
				      $( "#'.$this->id.'" ).toggle();
				    });
				  });	
		', CClientScript::POS_END);
		echo CHtml::dropDownList($this->name, $this->select, $this->data, $this->htmlOptions);
	}
}