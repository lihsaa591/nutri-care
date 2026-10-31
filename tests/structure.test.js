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

test( 'header ships the default menu links and a Book a call button', () => {
	const html = read( 'parts/header.html' );
	[ [ 'Services', 'services' ], [ 'About', 'about' ], [ 'Plans', 'pricing' ], [ 'Journal', 'journal' ], [ 'Contact', 'contact' ] ].forEach(
		( [ label, id ] ) => {
			assert.match( html, new RegExp( `wp:navigation-link \\{"label":"${ label }"[^}]*"url":"/#${ id }"` ), `${ label } link` );
		}
	);
	assert.match( html, /wp-block-button__link[^>]*href="\/#contact"[^>]*>Book a call</ );
} );

test( 'every default menu target exists as an anchor in the patterns', () => {
	const patterns = fs
		.readdirSync( path.join( root, 'patterns' ) )
		.map( ( f ) => fs.readFileSync( path.join( root, 'patterns', f ), 'utf8' ) )
		.join( '\n' );
	[ 'services', 'about', 'pricing', 'journal', 'contact' ].forEach( ( id ) =>
		assert.match( patterns, new RegExp( `id="${ id }"` ), `#${ id } anchor missing` )
	);
} );

test( 'full-width sections get side gutters, except the front-page wrapper', () => {
	const css = read( 'style.css' );
	assert.match( css, /\.wp-block-group\.alignfull\s*\{[^}]*padding-inline:\s*var\(--nc-gutter\)/ );
	assert.match( css, /--nc-gutter:\s*clamp\(/ );
	assert.match( css, /\.nc-flush\s*\{[^}]*padding-inline:\s*0/ );
	assert.match( read( 'templates/front-page.html' ), /"className":"nc-flush"[\s\S]*<main class="wp-block-group alignfull nc-flush">/ );
} );

test( 'mobile menu overlay has theme colours and its own padding', () => {
	assert.match( read( 'parts/header.html' ), /wp:navigation \{[^}]*"overlayBackgroundColor":"base"[^}]*"overlayTextColor":"contrast"/ );
	const css = read( 'style.css' );
	assert.match( css, /\.wp-block-navigation__responsive-container\.is-menu-open\s*\{[^}]*padding:/ );
	assert.match( css, /is-menu-open[^{]*\.wp-block-navigation-item__content/ );
} );

test( 'header menu is left-justified so the mobile overlay lists links from the left', () => {
	assert.match( read( 'parts/header.html' ), /wp:navigation \{[^}]*"layout":\{"type":"flex","justifyContent":"left"\}/ );
	const css = read( 'style.css' );
	assert.match( css, /\.wp-block-navigation \.wp-block-navigation__responsive-container\.is-menu-open\s*\{[^}]*padding:/ );
	assert.match( css, /\.wp-block-navigation-item__content\s*\{[^}]*text-align:\s*left/ );
} );

test( 'plate children are positioned with selectors strong enough to beat the editor', () => {
	const css = read( 'style.css' );
	assert.match( css, /\.nc-plate \.nc-plate__photo\s*\{[^}]*position:\s*absolute/ );
	assert.match( css, /\.nc-plate \.nc-plate__label\s*\{[^}]*position:\s*absolute/ );
	assert.match( css, /\.nc-plate \.nc-plate__caption\s*\{[^}]*position:\s*absolute/ );
} );

test( 'header and footer use the replaceable Site Logo block, with a palette-aware default mark', () => {
	[ 'parts/header.html', 'parts/footer.html' ].forEach( ( f ) => {
		const html = read( f );
		assert.match( html, /<!-- wp:site-logo \{[^}]*"width":36[^}]*\} \/-->/, `${ f } lacks the site logo block` );
		assert.doesNotMatch( html, /<svg/, `${ f } still hard-codes the svg` );
	} );
	const css = read( 'style.css' );
	[ 'nc-mark__a', 'nc-mark__c', 'nc-mark__t', 'nc-mark__leaf', 'nc-mark__vein' ].forEach( ( c ) =>
		assert.match( css, new RegExp( `\\.${ c }\\s*\\{` ), `${ c } style missing` )
	);
	assert.match( css, /\.nc-mark__a\s*\{[^}]*var\(--wp--preset--color--accent\)/ );
	const fn = read( 'functions.php' );
	assert.match( fn, /inc\/logo\.php/ );
	assert.match( fn, /add_filter\(\s*'render_block_core\/site-logo',\s*'nutri_care_site_logo_fallback'/ );
} );

test( 'screenshot.png is 1200x900 and the services heading has space above the first row', () => {
	const buf = fs.readFileSync( path.join( root, 'screenshot.png' ) );
	assert.strictEqual( buf.readUInt32BE( 16 ), 1200 );
	assert.strictEqual( buf.readUInt32BE( 20 ), 900 );
	assert.match( read( 'style.css' ), /\.wp-block-heading \+ \.wp-block-group\.nc-svc\s*\{[^}]*margin-block-start:\s*1\.75rem/ );
} );

test( 'style.css and readme.txt agree on Tested up to, and tags match the features', () => {
	const css = read( 'style.css' );
	const readme = read( 'readme.txt' );
	assert.match( css, /^Tested up to: 7\.1$/m );
	assert.match( readme, /^Tested up to: 7\.1$/m );
	const tags = css.match( /^Tags: (.+)$/m )[ 1 ].split( /,\s*/ );
	assert.ok( ! tags.includes( 'accessibility-ready' ), 'accessibility-ready triggers a separate review' );
	[ 'custom-logo', 'style-variations', 'block-patterns', 'full-site-editing' ].forEach( ( t ) => assert.ok( tags.includes( t ), `${ t } tag missing` ) );
} );

test( 'the built zip contains the theme and none of the development files', () => {
	const { execFileSync } = require( 'node:child_process' );
	execFileSync( 'bash', [ path.join( root, 'bin/build-zip.sh' ) ], { cwd: root, stdio: 'ignore' } );
	const files = execFileSync( 'unzip', [ '-Z1', path.join( root, 'dist/nutri-care.zip' ) ], { encoding: 'utf8' } ).split( '\n' );
	[ 'style.css', 'theme.json', 'readme.txt', 'screenshot.png', 'functions.php', 'templates/front-page.html' ].forEach( ( f ) =>
		assert.ok( files.includes( `nutri-care/${ f }` ), `${ f } missing from zip` )
	);
	const dev = files.filter( ( f ) => /(^|\/)(tests|bin|branding|vendor|node_modules|\.github|\.git)\/|phpcs\.xml|phpunit\.xml|composer\.|package(-lock)?\.json|\.sh$/.test( f ) );
	assert.deepStrictEqual( dev, [] );
} );

test( 'MeroDiet is described accurately: no appointment claims in the theme description, readme or notice, and install errors are shown', () => {
	[ 'style.css', 'readme.txt', 'inc/class-nutri-care-plugin-notice.php' ].forEach( ( f ) =>
		assert.doesNotMatch( read( f ), /appointment/i, `${ f } claims appointments` )
	);
	assert.match( read( 'assets/js/notice.js' ), /errorMessage/ );
	assert.ok( fs.existsSync( path.join( root, 'assets/css/notice.css' ) ), 'notice.css missing' );
} );
