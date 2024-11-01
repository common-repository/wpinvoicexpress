<?php

class RCDashboard implements Extension {


	public static function enable() {

		add_action('wp_dashboard_setup', function() {

			wp_add_dashboard_widget( 'rc_ix_dashboard_widget_pending_payments', 'Invoicexpress Pending', [ __CLASS__, 'renderDashboardWidgetPendingPayments' ] );

			wp_add_dashboard_widget( 'rc_ix_dashboard_widget_chart', 'Invoicexpress Chart', [ __CLASS__, 'renderDashboardWidgetChart' ] );

			wp_add_dashboard_widget( 'rc_ix_dashboard_widget_numbers', 'Invoicexpress Numbers', [ __CLASS__, 'renderDashboardWidgetNumbers' ] );

		});

		add_action( 'wp_ajax_get_chart_data', [ __CLASS__, 'getChartData' ] );

	}

	public static function renderDashboardWidgetNumbers() {

		RCCore::includeVendor( 'InvoicexpressClient/InvoicexpressInvoices' );
		$options = get_option( 'wpie_settings' );

		if ( ! empty( $options ) ) {

			$Invoices = new InvoicexpressInvoices( $options['domain'], $options['api_key'] );

			// Total owed
			$total_owed = [
				'total' => 0,
				'invoices' => $Invoices->all()->filter( 'status', ['draft', 'final'] )->get(),
			];

			foreach( $total_owed['invoices'] as $invoice ) {
				$total_owed['total'] += $invoice->find('total')->text();
			}

			// This month
			$date_start = strtotime('first day of last month');
			$date_end = strtotime('last day of last month');

			$current_month = [
				'total' => 0,
				'invoices' => $Invoices->all()->filter('status', 'settled')->filterDate( $date_start, $date_end )->get(),
			];
			foreach( $current_month['invoices'] as $invoice ) {
				$current_month['total'] += $invoice->find('total')->text();
			}
			
			// Monthly Average
			$date_start = strtotime('first day of january');
			$date_end = strtotime('last day of this month');

			$monthly_average = [
				'total' => 0,
				'invoices' => $Invoices->all()->filter('status', ['draft', 'settled', 'final'] )->filterDate( $date_start, $date_end )->get(),
			];
			foreach( $monthly_average['invoices'] as $invoice ) {
				$monthly_average['total'] += $invoice->find('total')->text();
			}
			$monthly_average['total'] = $monthly_average['total'] / date('m');
			
			
			RCCore::render('widget_dashboard_numbers', [ 
				'total_owed' => $total_owed,
				'current_month' => $current_month,
				'monthly_average' => $monthly_average
			]);


		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}

	public static function getChartData() {

		RCCore::includeVendor( 'InvoicexpressClient/InvoicexpressInvoices' );

		$options = get_option( 'wpie_settings' );

		$Invoices = new InvoicexpressInvoices( $options['domain'], $options['api_key'] );

		$rows = $Invoices->chart()->get();

		$labels = [];
		$values = [];

		foreach($rows->find('series value') as $row) {
			$labels[] = $row->text();
		}
		foreach($rows->find('graphs value') as $row) {
			$values[] = $row->text();
		}

		die(json_encode([ 'labels' => $labels, 'data' => $values ]));

	}

	public static function renderDashboardWidgetChart() {

		$options = get_option( 'wpie_settings' );

		if (!empty($options)) {

			RCCore::includeScript('Chart', 'assets/js/Chart.min.js', '1.0.2');
			RCCore::includeScript('ieapp', 'assets/js/app.js', '1.0.0');
			RCCore::render('widget_dashboard_chart');

		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}


	public static function renderDashboardWidgetPendingPayments() {

		RCCore::includeVendor('InvoicexpressClient/InvoicexpressInvoices');

		$options = get_option( 'wpie_settings' );

		if (!empty($options)) {

			$Invoices = new InvoicexpressInvoices($options['domain'], $options['api_key']);

			$pending = $Invoices->all()->filter('status', 'final')->get();
			$drafts = $Invoices->all()->filter('status', 'draft')->get();

			RCCore::render('widget_dashboard_invoices', [ 'pending' => $pending, 'drafts' => $drafts ]);

		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}

}