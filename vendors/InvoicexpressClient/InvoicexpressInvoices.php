<?php

require_once 'InvoicexpressAPIClient.php';
require_once 'FilterInterface.php';

class InvoicexpressInvoices extends InvoicexpressAPIClient implements Filter {

	protected $items = [];

	protected $items_pristine = [];


	public function chart() {

		$this->items = $this->fetch( 'api/charts/invoicing' );
		return $this;

	}

	public function get() {

		return $this->items;

	}

	public function all( $page = null ) {

		if ( empty( $this->items_pristine ) ) {
			$this->items_pristine = $this->items = $this->fetch( 'invoices' );
		} else {
			$this->items = $this->items_pristine;
		}

		$this->items = $this->items->find( 'invoices>invoice' );

		return $this;

	}

	public function filter( $field, $value ) {

		$this->items = $this->items->filterCallback(function($index, $item) use ($field, $value) {
			$text = qp($item)->find($field)->text();			
			if ( ! is_array( $value ) ) {
				return strpos($text, $value) !== FALSE;
			} else {
				return in_array($text, $value);
			}
		});

		return $this;

	}

	public function filterDate( $date_start, $date_end ) {

		$this->items = $this->items->filterCallback( function( $index, $item ) use ( $date_start, $date_end ) {
			$text = qp( $item )->find( 'due_date' )->text();
			$date = strtotime( implode( '-', array_reverse( explode( '/', $text ) ) ) );
			return ( $date_start <= $date && $date <= $date_end );
		});

		return $this;

	}

}