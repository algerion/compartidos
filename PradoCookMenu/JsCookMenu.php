<?php
/**
 * Class JsCookMenu.
 *
 * This is a prado dynamic menu component based on
 * JSCookMenu v2.0.3 (c) Copyright 2002-2006 by Heng Yuan
 * http://www.cs.ucla.edu/~heng/JSCookMenu/demo.html
 * Official Site: http://jscook.yuanheng.org/JSCookMenu/index.html
 *
 *
 * @author Victor Leite (Brasilia - Brazil) <victor.leite@gmail.com>
 * Example 1:

 	//-----------------
	//Page1.page
	//-----------------

		<com:JsCookMenu
		ID="myMenu"
		ThemeName 			= "ThemeOffice"
		JsCookMenuPath 		= "PradoCookMenu/JSCookMenu/JSCookMenu.js"
		StyleSheetThemePath = "PradoCookMenu/JSCookMenu/ThemeOffice/theme.css"
		JsThemePath 		= "PradoCookMenu/JSCookMenu/ThemeOffice/theme.js"
		MenuOrientation		= "hbr"
		>

		<com:JsCookMenuItem Title="Menu Topic 1">
			<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu Child 1" Url="http://www.google.com.br" Target="_blank" Description = "This is my menu"/>
			<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu Child 2" Url="index.php?page=programas.aplicacao.organismoInternacional.AppCadastroOrgInt"/>
			<com:JsCookMenuItem Break="true"/>
			<com:JsCookMenuItem Title="Menu Child 3">
				<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandChild 1" Url="http://www.google.com.br" Target="_blank" Description = "This is my menu"/>
				<com:JsCookMenuItem Disabled="true" ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandChild 2" Url="index.php?page=programas.aplicacao.organismoInternacional.AppCadastroOrgInt"/>
			</com:JsCookMenuItem>
		</com:JsCookMenuItem>

		<com:JsCookMenuItem Title="Menu Topic 2">
			<com:JsCookMenuItem ID="myItemVisible" Visible="false" ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu Child 4" Url="http://www.google.com.br" Target="_blank" Description = "This is my menu"/>
			<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu Child 5" Url="index.php?page=programas.aplicacao.organismoInternacional.AppCadastroOrgInt"/>
			<com:JsCookMenuItem Break="true"/>
			<com:JsCookMenuItem Title="Menu Child 6">
				<com:JsCookMenuItem Disabled="true" ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandChild 3" Url="http://www.google.com.br" Target="_blank" Description = "This is my menu"/>
				<com:JsCookMenuItem Disabled="true" ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandChild 4" Url="index.php?page=programas.aplicacao.organismoInternacional.AppCadastroOrgInt"/>
				<com:JsCookMenuItem Break="true"/>
				<com:JsCookMenuItem Title="Menu GrandChild 5">
					<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandGrandChild 1" Url="http://www.google.com.br" Target="_blank" Description = "This is my menu"/>
					<com:JsCookMenuItem ImagePath= "PradoCookMenu/imagens/00_minilinux.png" Title="Menu GrandGrandChild 2" Url="index.php?page=programas.aplicacao.organismoInternacional.AppCadastroOrgInt"/>
				</com:JsCookMenuItem>
			</com:JsCookMenuItem>
		</com:JsCookMenuItem>
	</com:JsCookMenu>

 	 <!--
   	 Note:
 	 JsCookMenu.MenuOrientation value could be: hbr or hbl or hur or hul or vbl or vur or vul
 	  for more details see http://www.cs.ucla.edu/~heng/JSCookMenu/demo.html
	 The image icons used here are 20x20 pixels
	 You can use others themes: ThemeIE, ThemeMiniBlack, ThemeOffice, ThemeOffice2003 or ThemePanel.
	 See the folder	yourPath/JSCookMenu/

	 Warning:
	 In a Template(.page) time, you cannot put two Items with the same ID.
     -->

	//-----------------
	//Page1.php
	//-----------------

		// That method can get a unique JsCookMenuItem or List of JsCookMenuItems
		$result = $this->myMenu->getAllItemsById("myItemVisible");
		// Just get a unique JsCookMenuItem
		if ($result != null) {
			$result->Visible = true;
			$result->Disabled = true;
		}

 *
 *---------------------------------------------------------------------------------------------------------------------------------------
 *
 * Example 2:

 	//-----------------
	//Page2.page
	//-----------------

		<com:JsCookMenu
			ID="myMenu"
			ThemeName 			= "ThemeOffice"
			JsCookMenuPath 		= "PradoCookMenu/JSCookMenu/JSCookMenu.js"
			StyleSheetThemePath = "PradoCookMenu/JSCookMenu/ThemeOffice/theme.css"
			JsThemePath 		= "PradoCookMenu/JSCookMenu/ThemeOffice/theme.js"
			MenuOrientation		= "hbr"
		/>

	 <!--
   	 Note:
 	 JsCookMenu.MenuOrientation value could be: hbr or hbl or hur or hul or vbl or vur or vul
 	  for more details see http://www.cs.ucla.edu/~heng/JSCookMenu/demo.html
	 The image icons used here are 20x20 pixels
	 You can use others themes: ThemeIE, ThemeMiniBlack, ThemeOffice, ThemeOffice2003 or ThemePanel.
	 See the folder	yourPath/JSCookMenu/

	 Warning:
	 When you create dinamically a JsCookMenuItem,
	 you can identify more than one control with the same ID.
	 So, you can create a group of Items with the same ID.

     -->

	//-----------------
	//Page2.php
	//-----------------


		// Topic Menu 1
		$item = new JsCookMenuItem;
		$item->setTitle("Menu Topic 1");
		$item->ID = "group1";
		$item->Visible = true; //Default value

		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 1");
		$subItem->ID = "group1";
		$subItem->Visible = true; //Default value
		$item->Controls->add($subItem);

		//Child 2
		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 2");
		$subItem->ID = "group1";
		$subItem->setUrl("http://www.gmail.com");
		// Add Child 2
		$item->Controls->add($subItem);

		//Break
		$subItem = new JsCookMenuItem;
		$subItem->ID = "group1";
		$subItem->setBreak();
		//Add Break
		$item->Controls->add($subItem);

		//Child 3
		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 3");
		$subItem->ID = "group1";
		$subItem->setUrl("http://www.yahoo.com.br");

			//GrandChilds
			$subItem2 = new JsCookMenuItem;
			$subItem2->ID = "group2";//LOOK HERE!! ITS A GROUP2. See that it will be Visible false. Discomment the code below.
			$subItem2->Disabled = true;
			$subItem2->setTitle("Menu GranChild 1 Disabled");
			$subItem2->setUrl("http://www.yahoo.com.br");
			$subItem2->setTarget("_blank");
			$subItem2->setDescription("This is my grandchild menu 1");

			$subItem3 = new JsCookMenuItem;
			$subItem3->ID = "group1";
			$subItem3->Disabled = true;
			$subItem3->setTitle("Menu GranChild 2 Disabled");
			$subItem3->setUrl("index.php?page=pradoPath.MyPradoPage");
			//$subItem3->setTarget("_self"); // Default value
			$subItem3->setDescription("This is my grandchild menu 2");

			$subItem4 = new JsCookMenuItem;
			$subItem4->ID = "group1";
			$subItem4->Disabled = false;
			$subItem4->setImagePath("PradoCookMenu/imagens/00_minilinux.png");
			$subItem4->setTitle("Menu GranChild 2 Anabled");
			$subItem4->setUrl("index.php?page=pradoPath.MyPradoPage");
			//$subItem3->setTarget("_self"); // Default value
			$subItem3->setDescription("This is my grandchild menu 2");

		// Add GrandChilds
		$subItem->Controls->add($subItem2);
		$subItem->Controls->add($subItem3);
		$subItem->Controls->add($subItem4);
		//Add Child
		$item->Controls->add($subItem);
		//Add Topic Menu 1
	  	$this->myMenu->Controls->add($item);


		// Topic Menu 2
		$item2 = new JsCookMenuItem;
		$item2->ID = "group3";
		$item2->ID = "Topic2";
		$item2->setTitle("Menu Topic 2");

		//Child 4
		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 4");
		$subItem->ID = "group3";
		//Add Child 4
		$item2->Controls->add($subItem);

		//Child 5
		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 5");
		$subItem->ID = "group2";//LOOK HERE!! ITS A GROUP2. See that it will be Visible false. Discomment the code below.
		$subItem->setUrl("http://www.gmail.com");
		//Add Child 5
		$item2->Controls->add($subItem);

		//Break
		$subItem = new JsCookMenuItem;
		$subItem->setBreak();
		$subItem->ID = "group3";
		//Add Break
		$item2->Controls->add($subItem);

		//Child 6
		$subItem = new JsCookMenuItem;
		$subItem->setTitle("Menu Child 6");
		$subItem->ID = "group3";
		$subItem->setUrl("http://www.gmail.com");
		//Add Child 6
		$item2->Controls->add($subItem);

		//Add Topic Menu 2
		$this->myMenu->Controls->add($item2);


		// That method can get a List of JsCookMenuItems(a group of JsCookMenuItem with the same ID)
		// or a unique JsCookMenuItem
		//$result = $this->myMenu->getAllItemsById("group2");
		// Just get a unique JsCookMenuItem
		//if ($result instanceof JsCookMenuItem) {
		//	$result->Visible = false;
		// Get more than one Item (TList)
		//}elseif ($result instanceof TList){
		//	foreach($result as $item){
		//		$item->Visible = false;
		//	}
		//}





 *---------------------------------------------------------------------------------------------------------------------------------------
 *
     REVISIONS:
     Ver        Date        Author          Description
     ---------  ----------  --------------  ------------------------------------
     1.0        28/12/2007  Victor Leite    1. Created JsCookMenu
	 1.1        18/01/2008  Victor Leite    2. Create the functionality to get Items by Id and set the visibility of an Item
 	 1.2        18/01/2008  Victor Leite    3. Create the functionality to set the Item Disabled
	 1.3        21/01/2008  Victor Leite    4. Updated the JsCookMenu.js version to 2.0.3

 */
class JsCookMenu extends TWebControl
{

    /**
     * @return string Path of JsCookMenu.js Defaults to ''.
     */
    public function getJsCookMenuPath()
    {
        return $this->getViewState('JsCookMenuPath','');
    }

    /**
     * @param string Path of JsCookMenu.js
     */
    public function setJsCookMenuPath($value)
    {
        $this->setViewState('JsCookMenuPath',TPropertyValue::ensureString($value),'');
    }


	  /**
     * @return string Get Theme used
     */
    public function getThemeName()
    {
        return $this->getViewState('ThemeName','');
    }

    /**
     * @param string Set Name of Theme
     */
    public function setThemeName($value)
    {
        $this->setViewState('ThemeName',TPropertyValue::ensureString($value),'');
    }


	 /**
     * @return string Path of JsCookMenu.js Defaults to ''.
     */
    public function getMenuOrientation()
    {
        return $this->getViewState('MenuOrientation','hbr');
    }

    /**
     * @param string Path of JsCookMenu.js
     */
    public function setMenuOrientation($value)
    {
        $this->setViewState('MenuOrientation',TPropertyValue::ensureString($value),'');
    }

    /**
     * @return string Path of Themes. Example: ../JsCookMenu/ThemeOffice/theme.css Defaults to ''.
     */
    public function getStyleSheetThemePath()
    {
        return $this->getViewState('StyleSheetThemePath','');
    }

    /**
     * @param string Path of Themes. Example: ../JsCookMenu/ThemeOffice/theme.css
     */
    public function setStyleSheetThemePath($value)
    {
        $this->setViewState('StyleSheetThemePath',TPropertyValue::ensureString($value),'');
    }

    /**
     * @return string Path of Javascript Themes. Example: ../JsCookMenu/ThemeOffice/theme.js Defaults to ''.
     */
    public function getJsThemePath()
    {
        return $this->getViewState('JsThemePath','');
    }

    /**
     * @param string Path of Javascript Themes. Example: ../JsCookMenu/ThemeOffice/theme.js
     */
    public function setJsThemePath($value)
    {
        $this->setViewState('JsThemePath',TPropertyValue::ensureString($value),'');
    }

	public function onInit($param){
		if($this->getJsCookMenuPath()==='')
			throw new TInvalidDataValueException("The JsCookMenuPath have to be setted");

		if($this->getThemeName()==='')
			throw new TInvalidDataValueException("The ThemeName have to be setted");

		if($this->getStyleSheetThemePath()==='')
			throw new TInvalidDataValueException("The StyleSheetThemePath have to be setted");

		if($this->getJsThemePath()==='')
			throw new TInvalidDataValueException("The JsThemePath have to be setted");
	}

	public function renderContents($writer) {

		$writer->write("<div id='".$this->Id."'></div>");
		$writer->write("<SCRIPT LANGUAGE='JavaScript' SRC='".$this->getJsCookMenuPath()."'></SCRIPT>\n");
		$writer->write("<SCRIPT LANGUAGE='JavaScript' SRC='".$this->getJsThemePath()."'></SCRIPT>\n");
		$writer->write("<LINK REL='stylesheet' HREF='".$this->getStyleSheetThemePath()."' TYPE='text/css'>\n");

		$writer->write("<script type='text/javascript'>");
			$writer->write("/*<![CDATA[*/");
				$writer->write("var arrMenu=[");
					$str = JsCookMenu::processControls($this);
					$writer->write($str);
					$writer->write("];");
		  		$writer->write("cmDraw ('".$this->Id."', arrMenu, '".$this->getMenuOrientation()."', cm".$this->getThemeName().", '".$this->getThemeName()."');");
	  	$writer->write("</script>");


		parent::renderContents($writer) ;
	}

	static function processControls(TWebControl $Control) {
		$str = '';
		//Verify if has more subitems
		if ($Control->Controls->Count > 0){
			$i = 0;
			foreach($Control->Controls as $Item){
				if ($Item instanceof JsCookMenuItem) {
					if($i>0 && $ItemAnterior->isVisible()){
						$str .= ", ";
					}
					//Verify if is not a Break
					if(!$Item->isBreak() && $Item->isVisible()){
						$str .= "[";
						$str .= (JsCookMenu::verifyEmptyValue($Item->getImagePath())==='null')? 'null,' : "'<img src=\"".$Item->getImagePath()."\"/>',";
						if(!$Item->isDisabled()){
							$str .= JsCookMenu::verifyEmptyValue($Item->getTitle()).",";
							$str .= JsCookMenu::verifyEmptyValue($Item->getUrl()).",";
							$str .= JsCookMenu::verifyEmptyValue($Item->getTarget()).",";
							$str .= JsCookMenu::verifyEmptyValue($Item->getDescription());
						}else{
							$str .= JsCookMenu::verifyEmptyValue("<span class=\'disabledTextItem\'>".$Item->getTitle()."</span>").",";
							$str .= JsCookMenu::verifyEmptyValue("").",";
							$str .= JsCookMenu::verifyEmptyValue("").",";
							$str .= JsCookMenu::verifyEmptyValue("");
						}
						if($Item->Controls->Count > 0){
							$rt = JsCookMenu::verifyEmptyValue(JsCookMenu::processControls($Item));
							$str .= ",";
							$str .= ($rt==='null') ? 'null' : " ".$rt;
						}
						$str .= "]";
					}else{
						if($Item->isBreak() && !$Item->isVisible()){
							//Do nothing
						}elseif ($Item->isBreak()){
							$str .= $Item->getBreakValue();
						}elseif(!$Item->isVisible()){
							//Do nothing
						}
					}
					$i++;
					$ItemAnterior = $Item;
				}else if ($Control instanceof JsCookMenu) {
					$str .= "[";
					$str .= (JsCookMenu::verifyEmptyValue($Item->getImagePath())==='null')? 'null,' : "'<img src=\"".$Item->getImagePath()."\"/>',";
					$str .= JsCookMenu::verifyEmptyValue($Item->getTitle()).",";
					$str .= JsCookMenu::verifyEmptyValue($Item->getUrl()).",";
					$str .= JsCookMenu::verifyEmptyValue($Item->getTarget()).",";
					$str .= JsCookMenu::verifyEmptyValue($Item->getDescription()).",";
					$rt   = JsCookMenu::verifyEmptyValue(JsCookMenu::processControls($Item));
					$str .= ($rt==='null') ? 'null' : " ".$rt;
					$str .= "]";
				}
			}
		}
		return $str;
	}
	static function verifyEmptyValue($value) {
		if($value===''){
			return 'null';
		}else{
			if(JsCookMenu::hasValue($value,"["))
				return $value;
			else
				return "'".$value."'";

		}

	}
	 /**
     * @return TList or JsCookMenuItem.
	 * This method will try to
	 * find a JsCookMenuItem or a list of this with the id passed on
     */
    public function getAllItemsById($id)
    {
		  if ($this->Controls->Count > 0){
		  	$list = new TList;
			foreach($this->Controls as $Item){
				if($Item->ID==$id) $list[] = $Item;
				JsCookMenu::getCollectionItemsById($Item, $id, $list);
			}
			if(count($list)==1)	return $list[0];//return the JsCookMenuItem founded
			else return $list;	//return the list of JsCookMenuItems founded
		  }else	return null;

    }
	/**
    * @return TList.
	* This method will try to
	* find a list with a JsCookMenuItem
    */
	static function getCollectionItemsById(JsCookMenuItem $control, $id, $list){
		 if ($control->Controls->Count > 0){
				foreach($control->Controls as $Item){
					if($Item->ID==$id) $list[] = $Item;
					JsCookMenu::getCollectionItemsById($Item, $id, $list);
				}
				return $list;
		  }

	}

	/**
	* Verify if exist a string inside other string
	**/
	static function hasValue($value, $findme){
		$pos = strpos("  $value",$findme);
		if ($pos === false) {
			return false;
		} else {
			return true;
		}
	}

	public function addParsedObject($Item)
	{

		if ($Item instanceof JsCookMenuItem) {
			$this->Controls[] = $Item;
		}
		elseif (! is_string($Item))
			throw new TInvalidDataTypeException(
				'child of JsCookMenu must be a JsCookMenuItem type ('
				. get_class($Item) . ' given)'
		);
	}


}

/**
 * Class JsCookMenuItem.
 * @author Victor Leite (Brasilia - Brazil) <victor.leite@gmail.com>

	 REVISIONS:
     Ver        Date        Author          Description
     ---------  ----------  --------------  ------------------------------------
     1.0        28/12/2007  Victor Leite    1. Created JsCookMenuItem
	 1.1        18/01/2008  Victor Leite    2. Add the attribute Visible
	 1.2        18/01/2008  Victor Leite    2. Add the attribute Disabled

 */
class JsCookMenuItem extends TWebControl implements INamingContainer
{
	 /**
     * @return string  Boolean
     */
    public function getDisabled()
    {
        return $this->getViewState('Disabled',false);
    }

    /**
     * @param string
     */
    public function setDisabled($value)
    {
        $this->setViewState('Disabled',TPropertyValue::ensureBoolean($value),false);
    }

     /**
     * @return string  Defaults to ''.
     */
    public function getVisible($checkParents = true)
    {
        return $this->getViewState('Visible',true);
    }
 	/**
    * @return string  Defaults to ''.
    */
	public function isDisabled()
    {
        return $this->getViewState('Disabled',false);
    }
    /**
     * @param string
     */
    public function setVisible($value)
    {
        $this->setViewState('Visible',TPropertyValue::ensureBoolean($value),true);
    }
	  /**
     * @return string  Defaults to ''.
     */
    public function isVisible()
    {
        return $this->getViewState('Visible',true);
    }


    /**
     * @return string  Defaults to ''.
     */
    public function getImagePath()
    {
        return $this->getViewState('ImagePath','');
    }

    /**
     * @param string
     */
    public function setImagePath($value)
    {
        $this->setViewState('ImagePath',TPropertyValue::ensureString($value),'');
    }

    /**
     * @return string  Defaults to ''.
     */
    public function getTitle()
    {
        return $this->getViewState('Title','');
    }

    /**
     * @param string
     */
    public function setTitle($value)
    {
        $this->setViewState('Title',TPropertyValue::ensureString($value),'');
    }

    /**
     * @return string  Defaults to ''.
     */
    public function getUrl()
    {
        return $this->getViewState('Url','');
    }

    /**
     * @param string
     */
    public function setUrl($value)
    {
        $this->setViewState('Url',TPropertyValue::ensureString($value),'');
    }

    /**
     * @return string  Defaults to '_self'.
     */
    public function getTarget()
    {
        return $this->getViewState('Target','_self');
    }

    /**
     * @param string
     */
    public function setTarget($value)
    {
        $this->setViewState('Target',TPropertyValue::ensureString($value),'_self');
    }

    /**
     * @return string  Defaults to ''.
     */
    public function getDescription()
    {
        return $this->getViewState('Description','');
    }

    /**
     * @param string
     */
    public function setDescription($value)
    {
        $this->setViewState('Description',TPropertyValue::ensureString($value),'');
    }

	 /**
     * @return string
     */
    public function isBreak()
    {
        if( $this->getViewState('break','') != '' ) return true;
		else return false;
    }
	 /**
     * @return string
     */
    public function getBreakValue()
    {
        return $this->getViewState('break','');
    }


	 /**
     * @param empty
     */
    public function setBreak()
    {
        $this->setViewState('break','_cmSplit');
    }



	public function addParsedObject($Item)
	{

		if ($Item instanceof JsCookMenuItem) {
			$this->Controls[] = $Item;
		}
		elseif (! is_string($Item))
			throw new TInvalidDataTypeException(
				'child of JsCookMenu must be a JsCookMenuItem type ('
				. get_class($Item) . ' given)'
		);
	}


}


?>