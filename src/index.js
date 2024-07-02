/**
 * External dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { Dropdown } from '@wordpress/components';
import * as Woo from '@woocommerce/components';
import { Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import './index.scss';

const MyExamplePage = () => (
	<Fragment>
		<Woo.Section component="article">
			<Woo.SectionHeader title={ __( 'Search', 'analytics-test' ) } />
			<Woo.Search
				type="products"
				placeholder="Search for something"
				selected={ [] }
				onChange={ ( items ) => setInlineSelect( items ) }
				inlineTags
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={ __( 'Dropdown', 'analytics-test' ) } />
			<Dropdown
				renderToggle={ ( { isOpen, onToggle } ) => (
					<Woo.DropdownButton
						onClick={ onToggle }
						isOpen={ isOpen }
						labels={ [ 'Dropdown' ] }
					/>
				) }
				renderContent={ () => <p>Dropdown content here</p> }
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={ __( 'Pill shaped container', 'analytics-test' ) }
			/>
			<Woo.Pill className={ 'pill' }>
				{ __( 'Pill Shape Container', 'analytics-test' ) }
			</Woo.Pill>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={ __( 'Spinner', 'analytics-test' ) } />
			<Woo.H>I am a spinner!</Woo.H>
			<Woo.Spinner />
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={ __( 'Datepicker', 'analytics-test' ) } />
			<Woo.DatePicker
				text={ __( 'I am a datepicker!', 'analytics-test' ) }
				dateFormat={ 'MM/DD/YYYY' }
			/>
		</Woo.Section>
	</Fragment>
);

addFilter( 'woocommerce_admin_pages_list', 'analytics-test', ( pages ) => {
	pages.push( {
		container: MyExamplePage,
		path: '/analytics-test',
		breadcrumbs: [ __( 'Analytics Test 2', 'analytics-test' ) ],
		navArgs: {
			id: 'analytics_test_2',
		},
	} );

	return pages;
} );
