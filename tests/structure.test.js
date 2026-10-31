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

test( 'front-page composes the ten patterns in order', () => {
	const html = read( 'templates/front-page.html' );
	const slugs = [ ...html.matchAll( /wp:pattern \{"slug":"nutri-care\/([a-z-]+)"/g ) ].map( ( m ) => m[ 1 ] );
	assert.deepStrictEqual( slugs, [
		'hero',
		'services',
		'about',
		'process',
		'pricing',
		'testimonials',
		'faq',
		'booking-cta',
		'blog',
		'contact',
	] );
} );

test( 'functions.php loads the plugin notice only in the admin', () => {
	const src = read( 'functions.php' );
	assert.match( src, /inc\/class-nutri-care-plugin-notice\.php/ );
	assert.match( src, /is_admin\(\)[\s\S]*Nutri_Care_Plugin_Notice\(\)\s*\)->register\(\)/ );
} );

test( 'footer has four columns and no invalid paragraph align', () => {
	const html = read( 'parts/footer.html' );
	assert.strictEqual( ( html.match( /<!-- wp:column[ -]/g ) || [] ).length, 4 );
	assert.doesNotMatch( html, /wp:paragraph \{[^}]*"align"/ );
} );

test( 'search empty state says no results and offers a new search', () => {
	const html = read( 'templates/search.html' );
	const empty = html.slice( html.indexOf( 'wp:query-no-results' ) );
	assert.match( empty, /No results/i );
	assert.match( empty, /wp:search/ );
} );

test( 'posts index has a level 1 heading', () => {
	assert.match( read( 'templates/index.html' ), /wp:heading \{"level":1/ );
} );

test( 'functions.php enqueues style.css on the front end and in the editor', () => {
	const src = read( 'functions.php' );
	assert.match( src, /wp_enqueue_style\(\s*'nutri-care-style',\s*get_stylesheet_uri\(\)/ );
	assert.match( src, /add_action\(\s*'wp_enqueue_scripts',\s*'nutri_care_enqueue_styles'/ );
	assert.match( src, /add_editor_style\(\s*'style\.css'/ );
} );
