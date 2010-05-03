<?php


/*
 *
 *
 *	$body['body div#canvas'] = 
 
 *	$body['body'] = $oC;
 *	$body[];
 *
 *	echo sm( $head, $body );
 *
 *
 *
 *
 *
 *
 *
 */
 
//	body div#container h1.important | < a[href="URL";] | < {color:red;}:hover
//	---- ------------- ------------   - -------------  | - -------------------
//	|       |            |          | |  |             | |  |           |
//	face    ident.       class      | |  attribute     | |  style       pseudo
//	---- ------------- ------------ | | -------------  | | -------------------
//	     |             |            | |                | |
//	     parent        child        | previous parent  | previous parent (a)
//					| (div#container)  |
//
//	div #<identifier>.<class> [] {} :
//	--- --------------------- -- -- -
//	|      |                  |  |  |
//	|      |                  |
//	|      linkers            attributes
//	face
//
//
//	<
//	-
//	|
//	iterator
//
//
//	Definitions
//	===========
//
//	o Iterator:	A symbol defining the relativity of the declaration
//	oo <:		A back iterator; sets the statement to the previous or initial parent
//	
//	o Faces: 	An ML entity; can have Linkers, Attributes and Styles with Pseudos
//	oo Linkers: 	Either classes or an identifier
//	ooo Class: 	A face class; they start with a dot (.) e.g.: .important; can have many concatenated
//	ooo Identifier: A face identifier; it starts with a sharp (#) e.g.: #container; on per face
//	oo Attributes:	Attributes of the face; name/value pairs e.g.: name="value", separated by semi-colons (;), enclosed in brackets ([...]);
//	oo Styles:	Styles of the face; CSS styles; property/value pairs e.g.: color:red; separated by semi-colons (;), enclosed in braces ({...});
//	oo Pseudos:	Pseudo of styles; CSS pseudo styles; name of the pseudo starting with a colon (:); can only have one
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
		
	}
	
	
	protected function _SeparateFaces( $sFacesDeclaration )
	{
		$aFaces = explode( ' ', trim( $sFacesDeclaration ) );
		
		return $aFaces;
	}
	

	public function Parse( $aSMDoc )
	{
		foreach ( $aSMDoc as $sPath )
		{
			// Gets faces
			$aFaces = $this->_SeparateFaces( $sFacesDeclaration );
			
			// Separates faces from attributes
			foreach ( $aFaces as $sFace )
			{
				preg_match( PARSE_PTRN_FACES, $sFace, $aMatches );
				
				print_r( $aMatches );
			}
			
		}
	}
	
	
	public function XHTML_Parse( $sLangCode, $sEncoding, $hHead, $hBody )
	{
		$this->_
		
	}
}


class Face
{
	private $_sName;
	
	private $_aClasses;
	
	private $_sIdentifier;
	
	
	public function __construct( $sFace )
	{
		if ( strlen( $sFace ) > 0 )
		{
			$this->SplitFace( $sFace );
		}
	}
	
	
	public SplitFace( $sFace )
	{
		preg_match( PARSE_PTRN_ );
	}
}


function sm( $aSMDoc )
{
	$oSM = new PHPSM();
	
	$sSMDoc = $oSM->Parse( $aSMDoc );
	
	return $sSMDoc;
}


function xm_xhtml()
{
	
}


?>
