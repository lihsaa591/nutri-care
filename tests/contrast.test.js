const test = require( 'node:test' );
const assert = require( 'node:assert' );
const fs = require( 'node:fs' );
const path = require( 'node:path' );

const themeJson = JSON.parse(
	fs.readFileSync( path.join( __dirname, '..', 'theme.json' ), 'utf8' )
);

const color = ( slug ) =>
	themeJson.settings.color.palette.find( ( c ) => c.slug === slug ).color;

const channel = ( v ) => {
	const s = v / 255;
	return s <= 0.03928 ? s / 12.92 : Math.pow( ( s + 0.055 ) / 1.055, 2.4 );
};

const luminance = ( hex ) => {
	const n = parseInt( hex.slice( 1 ), 16 );
	return (
		0.2126 * channel( ( n >> 16 ) & 255 ) +
		0.7152 * channel( ( n >> 8 ) & 255 ) +
		0.0722 * channel( n & 255 )
	);
};

const ratio = ( a, b ) => {
	const [ hi, lo ] = [ luminance( a ), luminance( b ) ].sort( ( x, y ) => y - x );
	return ( hi + 0.05 ) / ( lo + 0.05 );
};

test( 'palette pairs meet AA', () => {
	assert.ok( ratio( color( 'contrast' ), color( 'base' ) ) >= 7 );
	assert.ok( ratio( color( 'contrast' ), color( 'soft' ) ) >= 7 );
	assert.ok( ratio( color( 'accent' ), color( 'base' ) ) >= 4.5 );
	assert.ok( ratio( color( 'accent' ), color( 'soft' ) ) >= 4.5 );
	assert.ok( ratio( color( 'base' ), color( 'contrast' ) ) >= 7 );
} );
