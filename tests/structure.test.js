const test = require( 'node:test' );
const assert = require( 'node:assert' );
const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.join( __dirname, '..' );
const read = ( f ) => fs.readFileSync( path.join( root, f ), 'utf8' );

const templates = [ 'index', 'front-page', 'page', 'single', 'archive', 'search', '404' ].map(
	( n ) => `templates/${ n }.html`
);
const parts = [ 'header', 'footer' ].map( ( n ) => `parts/${ n }.html` );

const balanced = ( html ) => {
	const stack = [];
	const re = /<!--\s*(\/)?wp:([a-z0-9/-]+)[^>]*?(\/)?-->/g;
	let m;
	while ( ( m = re.exec( html ) ) ) {
		const [ , closing, name, selfClosing ] = m;
		if ( selfClosing ) {
			continue;
		}
		if ( closing ) {
			if ( stack.pop() !== name ) {
				return false;
			}
		} else {
			stack.push( name );
		}
	}
	return stack.length === 0;
};

test( 'required files exist', () => {
	[ ...templates, ...parts ].forEach( ( f ) =>
		assert.ok( fs.existsSync( path.join( root, f ) ), `${ f } missing` )
	);
} );

test( 'block comments are balanced', () => {
	[ ...templates, ...parts ].forEach( ( f ) =>
		assert.ok( balanced( read( f ) ), `${ f } has unbalanced block comments` )
	);
} );

test( 'search and 404 and listing templates have empty-state text', () => {
	assert.match( read( 'templates/404.html' ), /not found|couldn.t find/i );
	[ 'search', 'archive', 'index' ].forEach( ( n ) =>
		assert.match( read( `templates/${ n }.html` ), /query-no-results/ )
	);
} );

test( 'templates use header and footer parts', () => {
	templates.forEach( ( f ) => {
		const html = read( f );
		assert.match( html, /wp:template-part \{"slug":"header"/ );
		assert.match( html, /wp:template-part \{"slug":"footer"/ );
	} );
} );
