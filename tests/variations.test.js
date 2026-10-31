const test = require( 'node:test' );
const assert = require( 'node:assert' );
const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.join( __dirname, '..' );
const readJson = ( f ) => JSON.parse( fs.readFileSync( path.join( root, f ), 'utf8' ) );
const slugs = [ 'contrast', 'accent', 'soft', 'base', 'muted', 'deep', 'tint', 'line' ];

const channel = ( v ) => {
	const s = v / 255;
	return s <= 0.03928 ? s / 12.92 : Math.pow( ( s + 0.055 ) / 1.055, 2.4 );
};
const lum = ( hex ) => {
	const n = parseInt( hex.slice( 1 ), 16 );
	return 0.2126 * channel( ( n >> 16 ) & 255 ) + 0.7152 * channel( ( n >> 8 ) & 255 ) + 0.0722 * channel( n & 255 );
};
const ratio = ( a, b ) => {
	const [ hi, lo ] = [ lum( a ), lum( b ) ].sort( ( x, y ) => y - x );
	return ( hi + 0.05 ) / ( lo + 0.05 );
};

const palettes = { default: readJson( 'theme.json' ).settings.color.palette };
[ 'sage', 'terracotta', 'ocean', 'plum' ].forEach( ( n ) => {
	const file = `styles/colors/${ n }.json`;
	assert.ok( fs.existsSync( path.join( root, file ) ), `${ file } missing` );
	palettes[ n ] = readJson( file ).settings.color.palette;
} );

test( 'five palettes define every colour slug', () => {
	Object.entries( palettes ).forEach( ( [ name, pal ] ) =>
		slugs.forEach( ( s ) => assert.ok( pal.find( ( c ) => c.slug === s ), `${ name } lacks ${ s }` ) )
	);
} );

test( 'every palette meets AA contrast', () => {
	Object.entries( palettes ).forEach( ( [ name, pal ] ) => {
		const c = ( s ) => pal.find( ( x ) => x.slug === s ).color;
		assert.ok( ratio( c( 'contrast' ), c( 'base' ) ) >= 7, `${ name } contrast/base` );
		assert.ok( ratio( c( 'contrast' ), c( 'soft' ) ) >= 7, `${ name } contrast/soft` );
		assert.ok( ratio( c( 'accent' ), c( 'base' ) ) >= 4.5, `${ name } accent/base` );
		assert.ok( ratio( c( 'accent' ), c( 'soft' ) ) >= 4.5, `${ name } accent/soft` );
		assert.ok( ratio( c( 'muted' ), c( 'base' ) ) >= 4.5, `${ name } muted/base` );
		assert.ok( ratio( c( 'muted' ), c( 'soft' ) ) >= 4.5, `${ name } muted/soft` );
		assert.ok( ratio( c( 'base' ), c( 'deep' ) ) >= 7, `${ name } base on deep` );
	} );
} );

test( 'colour variations have titles', () => {
	[ [ 'sage', 'Sage' ], [ 'terracotta', 'Terracotta' ], [ 'ocean', 'Ocean' ], [ 'plum', 'Plum' ] ].forEach( ( [ n, title ] ) =>
		assert.strictEqual( readJson( `styles/colors/${ n }.json` ).title, title )
	);
} );

test( 'style.css, patterns, parts and templates hard-code no hex colours', () => {
	const files = [ 'style.css' ];
	[ 'patterns', 'parts', 'templates' ].forEach( ( d ) =>
		fs.readdirSync( path.join( root, d ) ).forEach( ( f ) => files.push( `${ d }/${ f }` ) )
	);
	files.forEach( ( f ) => {
		const hits = fs.readFileSync( path.join( root, f ), 'utf8' ).match( /#[0-9a-fA-F]{6}\b/g );
		assert.strictEqual( hits, null, `${ f } hard-codes ${ hits }` );
	} );
} );

test( 'Inter typography variation is bundled and swaps heading and body fonts', () => {
	const v = readJson( 'styles/typography/inter.json' );
	assert.strictEqual( v.title, 'Inter' );
	const fam = v.settings.typography.fontFamilies.find( ( f ) => f.slug === 'inter' );
	assert.ok( fam && fam.fontFace.length >= 2 );
	fam.fontFace.forEach( ( face ) =>
		assert.ok( fs.existsSync( path.join( root, face.src[ 0 ].replace( 'file:./', '' ) ) ), `${ face.src[ 0 ] } missing` )
	);
	assert.match( v.styles.typography.fontFamily, /inter/ );
	assert.match( v.styles.elements.heading.typography.fontFamily, /inter/ );
	assert.match( v.settings.custom.fontDisplay, /inter/ );
} );

test( 'display text follows the heading font through a theme.json custom value', () => {
	assert.match( readJson( 'theme.json' ).settings.custom.fontDisplay, /fraunces/ );
	assert.match( fs.readFileSync( path.join( root, 'style.css' ), 'utf8' ), /var\(--wp--custom--font-display\)/ );
	assert.doesNotMatch( fs.readFileSync( path.join( root, 'style.css' ), 'utf8' ), /font-family:\s*var\(--wp--preset--font-family--fraunces\)/ );
} );

test( 'readme credits Inter under the OFL', () => {
	assert.match( fs.readFileSync( path.join( root, 'readme.txt' ), 'utf8' ), /Inter by Rasmus Andersson/ );
} );
