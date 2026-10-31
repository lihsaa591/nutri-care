const test = require( 'node:test' );
const assert = require( 'node:assert' );
const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.join( __dirname, '..' );
const themeJson = JSON.parse( fs.readFileSync( path.join( root, 'theme.json' ), 'utf8' ) );
const families = themeJson.settings.typography.fontFamilies;

test( 'Fraunces and DM Sans are bundled and declared with local font files', () => {
	[ 'fraunces', 'dm-sans' ].forEach( ( slug ) => {
		const family = families.find( ( f ) => f.slug === slug );
		assert.ok( family, `${ slug } family missing` );
		assert.ok( family.fontFace.length >= 2, `${ slug } needs latin and latin-ext faces` );
		family.fontFace.forEach( ( face ) => {
			assert.match( face.src[ 0 ], /^file:\.\/assets\/fonts\/.+\.woff2$/ );
			assert.ok( fs.existsSync( path.join( root, face.src[ 0 ].replace( 'file:./', '' ) ) ), `${ face.src[ 0 ] } missing` );
		} );
	} );
} );

test( 'body uses DM Sans and headings use Fraunces', () => {
	assert.match( themeJson.styles.typography.fontFamily, /dm-sans/ );
	assert.match( themeJson.styles.elements.heading.typography.fontFamily, /fraunces/ );
} );

test( 'readme credits both fonts under the OFL', () => {
	const readme = fs.readFileSync( path.join( root, 'readme.txt' ), 'utf8' );
	assert.match( readme, /Fraunces/ );
	assert.match( readme, /DM Sans/ );
	assert.match( readme, /SIL Open Font License/ );
} );
