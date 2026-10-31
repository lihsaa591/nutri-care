const test = require( 'node:test' );
const assert = require( 'node:assert' );
const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.join( __dirname, '..' );
const names = [
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
];
const read = ( n ) =>
	fs.readFileSync( path.join( root, 'patterns', `${ n }.php` ), 'utf8' );

// Visible text only: drop PHP, block comments and tags.
const visibleText = ( src ) =>
	src
		.replace( /<\?php[\s\S]*?\?>/g, ' ' )
		.replace( /<!--[\s\S]*?-->/g, ' ' )
		.replace( /<svg[\s\S]*?<\/svg>/g, ' ' )
		.replace( /<[^>]+>/g, ' ' );

test( 'every pattern has a header with Title, Slug nutri-care/<name>, Categories nutri-care', () => {
	names.forEach( ( n ) => {
		const src = read( n );
		assert.match( src, /\* Title: .+/, `${ n } Title` );
		assert.match( src, new RegExp( `\\* Slug: nutri-care/${ n }\\b` ), `${ n } Slug` );
		assert.match( src, /\* Categories: nutri-care\b/, `${ n } Categories` );
	} );
} );

test( 'no pattern contains cure, reverse, guarantee or before-and-after wording', () => {
	names.forEach( ( n ) =>
		assert.doesNotMatch(
			read( n ),
			/\bcures?\b|\breverse[sd]?\b|guarantee|before[ -]and[ -]after/i,
			`${ n } has a risky claim`
		)
	);
} );

test( 'booking-cta uses the core login URL and a contact anchor, and nothing from merodiet', () => {
	const src = read( 'booking-cta' );
	assert.match( src, /wp_login_url\(/ );
	assert.match( src, /#contact/ );
	assert.doesNotMatch( src, /merodiet/i );
} );

test( 'testimonials carries a results-vary note', () => {
	assert.match( read( 'testimonials' ), /results vary/i );
} );

test( 'pricing has exactly three plan columns', () => {
	const count = ( read( 'pricing' ).match( /class="[^"]*\bnc-plan\b/g ) || [] ).length;
	assert.strictEqual( count, 3 );
} );

test( 'all visible strings are translatable', () => {
	names.forEach( ( n ) => {
		const leftover = visibleText( read( n ) ).replace( /[\s\d%$+→·×©.,:;!?'"()/&-]+/g, ' ' ).trim();
		assert.strictEqual( leftover, '', `${ n } has untranslated text: ${ leftover.slice( 0, 60 ) }` );
		assert.doesNotMatch( read( n ), /esc_(html|attr)_?e?\(\s*'[^']*',\s*'(?!nutri-care')/, `${ n } wrong text domain` );
	} );
} );

test( 'patterns hotlink no external URLs and reference only bundled images', () => {
	names.forEach( ( n ) => {
		const src = read( n );
		const external = ( src.match( /(?:src|href|url|"url")\s*[=:]\s*\\?"https?:\/\/(?!www\.w3\.org)[^"]*/g ) || [] );
		assert.deepStrictEqual( external, [], `${ n } uses an external URL` );
		( src.match( /assets\/images\/[a-z0-9-]+\.webp/g ) || [] ).forEach( ( img ) =>
			assert.ok( fs.existsSync( path.join( root, img ) ), `${ n } references missing ${ img }` )
		);
	} );
} );

test( 'functions.php registers the nutri-care pattern category', () => {
	const src = fs.readFileSync( path.join( root, 'functions.php' ), 'utf8' );
	assert.match( src, /register_block_pattern_category\(\s*'nutri-care'/ );
} );

test( 'every bundled image is used and credited in readme.txt', () => {
	const dir = path.join( root, 'assets', 'images' );
	const readme = fs.existsSync( path.join( root, 'readme.txt' ) )
		? fs.readFileSync( path.join( root, 'readme.txt' ), 'utf8' )
		: '';
	const usage = [ ...names.map( read ), fs.readFileSync( path.join( root, 'style.css' ), 'utf8' ) ].join( '\n' );
	fs.readdirSync( dir ).forEach( ( img ) => {
		assert.ok( usage.includes( img ), `${ img } is bundled but never used` );
		assert.ok( readme.includes( img ), `${ img } is not credited in readme.txt` );
		assert.match( readme, /CC0/ );
	} );
} );

test( 'translatable strings contain no HTML entities', () => {
	names.forEach( ( n ) =>
		assert.doesNotMatch( read( n ), /esc_(html|attr)_e\(\s*'[^']*&amp;/, `${ n } double-escapes an entity` )
	);
} );

test( 'services rows do not force nowrap in block markup', () => {
	assert.doesNotMatch( read( 'services' ), /"flexWrap":"nowrap"/ );
} );

test( 'hero plate photo and labels are editable blocks, not raw HTML', () => {
	const src = read( 'hero' );
	assert.doesNotMatch( src, /<!-- wp:html/ );
	assert.match( src, /<!-- wp:image \{[^}]*nc-plate__photo[^}]*\} -->[\s\S]*assets\/images\/plate-bowl\.webp/ );
	assert.strictEqual( ( src.match( /<!-- wp:paragraph \{"className":"nc-plate__label/g ) || [] ).length, 3 );
	assert.match( src, /<!-- wp:paragraph \{"className":"nc-plate__caption"\}/ );
} );
