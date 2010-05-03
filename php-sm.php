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
 
//	body div#container h1.important | < a[href="URL";] | < p{color:red;}:hover
//	---- ------------- ------------   - -------------  | - -------------------
//	|       |            |          | |  |             |    |           |
//	face    ident.       class      | |  attribute     |    style       pseudo
//	---- ------------- ------------ | | -------------  | - -------------------
//	     |             |            | |                |
//	     parent        child        | previous parent  |
//
//
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
	

	public function Parse( $aSMDoc )
	{
		foreach ( $aSMDoc as $sPath )
		{
			// Gets faces
			$aFaces = explode( ' ', trim($sPath) );
			
			// Separates faces from attributes
			foreach ( $aFaces as $sFace )
			{
				preg_match( PARSE_PTRN_FACES, $sFace, $aMatches );
				
				print_r( $aMatches );
			}
			
		}
	} 
}


function sm( $aSMDoc )
{
	$oSM = new PHPSM();
	
	$sSMDoc = $oSM->Parse( $aSMDoc );
	
	return $sSMDoc;
}


?>
