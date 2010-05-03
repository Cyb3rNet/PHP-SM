<?php


/*
 *
	$head = array();

	$head['title'] = "My first SM document";

	$body = array();

	$body['body div#canvas h1'] = 'Hello World!';
	$body['< p'] = 'I'm a paragraph.';

	echo sm_xhtml( $head, $body [ , $sLangCode [, $sEncoding ] ] );

	Will produce (without spacing):
	============

	<html>
	<head>
		<title>My first SM document</title>
	</head>
	<body>
		<h1 id="canvas">Hello World!</h1>
		<p>I'm a paragraph.</p>
	</body>
 
 *
 */

//	Example of combined statements; separated by the pipe (|);
//
//	body div#container h1.important | < a[href="URL";] | - {color:red;}:hover
//	---- ------------- ------------ | - -------------  | - ------------------
//	|       |            |          | |  |             | |  |          |
//	face    ident.       class      | |  attribute     | |  style      pseudo
//	---- ------------- ------------ | | -------------  | | ------------------
//	     |             |            | |                | |
//	     parent        child        | previous parent  | previous element (a)
//					| (div#container)  |
//
//
//	Statement Definition
//	====================
//
//	div #<identifier> .<class> [] {} :
//	----------------------------------
//	|
//	face
//	    ------------- -------- -- -- -
//	    |             |        |  |  |
//	    identifier    class    |  |  |
//	    ---------------------- |  |  |
//	       |                   |  |  |
//	       |                   |  |  pseudo
//	       |                   |  styles
//	       linkers             attributes
//	
//
//
//	< or -
//	------
//	|
//	iterator
//
//
//	Definitions
//	===========
//
//	o Iterator:	A symbol defining the relativity of the declaration
//	oo <:		A parent iterator; sets the statement to the previous or initial parent
//	oo -:		A sibling iterator; links the statement to the previous entity; only for standalone attributes and styles declarations
//	
//	o Faces: 	An ML entity; can have Linkers, Attributes and Styles with Pseudos
//	oo Linkers: 	Either classes or an identifier
//	ooo Class: 	A face class; they start with a dot (.) e.g.: .important; can have many concatenated
//	ooo Identifier: A face identifier; it starts with a sharp (#) e.g.: #container; on per face
//	oo Attributes:	Attributes of the face; name/value pairs e.g.: name="value", separated by semi-colons (;), enclosed in brackets ([...]);
//	oo Styles:	Styles of the face; CSS styles; property/value pairs e.g.: color:red; separated by semi-colons (;), enclosed in braces ({...});
//	oo Pseudo:	Pseudo of styles; CSS pseudo styles; name of the pseudo starting with a colon (:); can only have one
//
//	- body : 		face
//	- div#container : 	face with identifier
//	- h1.important : 	face with class
//	- | : 			pipe; faces declaration separator
//	- < a[href="URL"] : 	face with attribute; within the previous parent
//	- < p{color:red} :	face with style; within the previous parent


/**
 *	@name PARSE_PTRN_FACES Parse pattern to identify attributes
 */
define( 'PARSE_PTRN_FACES', '/([a-zA-Z0-9\.#]+)\[\([a-zA-Z0-9=\";)]+;\]/' );

 class PHPSM
{
	public function __construct()
	{
		$this->_aoFaces = array();
	}
	
	
	protected function _ParsePaths( $sPath )
	{
		$oFace = new Face( $sPath );
	
		if ( $oFace->IsRelative() )
		{
			switch ( $oFace->GetRelativeIterator() )
			{
				case SM_ITER_PREV_PARENT:
				
				break;
				case SM_ITER_PREV_SIBLING:
				
				break;
				default:
					throw new Exception( '' );
			}
		}
		
		$oFaceDecl = new Declaration( $oFace, $sContent );	
	}
	
	
	protected function _Parse( $oParent, $sPath, $sContent )
	{
	
	}
	

	public function XHTML_Parse( $hsHead, $hsBody, $sLangCode, $sEncoding )
	{
		// Set head
		$oHeadFace = new Face( 'head' );
		
		$oHeadDecl = new Declaration( $oHeadFace );

		foreach ( $hsHead as $sPath => $sContent )
		{
			$asShellToCoreFaces = explode( ' ', $sPath );
			
			foreach ( $asCoreToShellFaces as $sInnerFace )
			{
				$oInnerFace = new Face( $sInnerFace );
				
				$oInnerDecl = new Declaration( $oInnerFace, $sContent );
				
				if ( ! is_null( $oLastDecl ) )
				{
					$oInnerDecl->AppendChild( $oLastDecl );
				}
				
				$oLastDecl = $oInnerDecl;
			}
			
			$oHeadDecl->AppendChild( $oFaceDecl );
		}
		
		// Set body
		foreach ( $hsBody as $sPath => $sContent )
		{
			
		}
		
		// Set document
		$oDocFace = new Face( 'html' );
		
		$oDocDecl = new Declaration( $oDocFace );
		
		$oDocDecl->AppendChild( $oHeadDecl );
		$oDocDecl->AppendChild( $oBodyDecl );
		
		// Generate document
		return $this->GenerateXHTML( $oDocDecl );
	}
	
	
	public function GenerateXHTML( $oDocDecl )
	{
		
	}
}


class Declaration
{
	public function __construct( $oFace, $sContent = "", $aChildFaces = array() )
	{
		$this->_oFace = $oFace;
		$this->_sContent = $sContent;
		$this->_aoChildFaces = $aChildFaces;
	}
	
	public function GetFace()
	{
		return $this->_oFace;
	}
	
	public function GetContent()
	{
		return $this->_sContent;
	}
	
	public function GetChilds()
	{
		return $this->_aChilds;
	}
	
	public function AppendChild( $oChildFace )
	{
		$this->_aoChildFaces[] = $oChildFace;
	}
}


class Face
{
	private $_sName;
	
	private $_aClasses;
	
	private $_sIdentifier;
	
	private $_hsAttributes;
	
	private $_hsStyles;
	
	private $_sPseudo;
	
	public function __construct( $sFace )
	{
		$this->_sName = "";
		$this->_aClasses = array();
		$this->_sIdentifier = "";
		$this->_hsAttributes = array();
		$this->_hsStyles = array();
		$this->_sPseudo = "";
		
		$this->_iRootDistance = 0;

		if ( strlen( $sFace ) > 0 )
		{
			$this->SplitFace( $sFace );
		}
	}
	
	
	protected function _GetLinkers()
	{
		
	}
	
	
	protected function _GetAttributes()
	{
	
	}
	
	
	protected function _GetStyles()
	{
	
	}
	
	
	public SplitFace( $sFace )
	{
		$a
		
		$sLinkers = $this->_GetLinkers();
	}
}


/**
 *	Creates a generic Styled Markup document
 *
 *	@todo To make styled XML documents
 */
function sm( $aSMDoc )
{
	$oSM = new PHPSM();
	
	$sSMDoc = $oSM->Parse( $aSMDoc );
	
	return $sSMDoc;
}


/**
 *	Creates a styled XHTML document 
 */
function xm_xhtml( $hsHead, $hsBody, $sLangCode = "en", $sEncoding = "UTF-8" )
{
	$oSM = new PHPSM();
	
	$sSMDoc = $oSM->XHTML_Parse( $hsHead, $hsBody, $sLangCode, $sEncoding );
	
	return $sSMDoc;
}


?>
