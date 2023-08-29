<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;


class GenerateInvocePDFService
{
	public static function loadView($data)
	{
		$products = [];
		$total = [
			'sum' => 0,
			'quantity' => 0,
		];

		foreach ($data['products'] as $product) {
			$productSum = $product['price'] * $product['quantity'];

			$product = [
				'name' => $product['name'],
				'quantity' => number_format($product['quantity']),
				'price' => $product['price'],
				'sum' => number_format($productSum, 2)
			];

			$products[] = $product;

			$total['sum'] += (float) $productSum;
			$total['quantity'] += (int) $product['quantity'];
		}

		$invoiceData = [
			'id' => '123123/123',
			'date' => date('d.m.Y'),
			'logo' => data_get($data, 'supplier.logo'),
			'supplier' => $data['supplier'],
			'client' => $data['client'],
			'products' => $products,
			'total' => [
				'sum' => number_format($total['sum'], 2),
				'quantity' => number_format($total['quantity']),
			],
		];

		$pdf = Pdf::loadView('invoce', $invoiceData);
		$pdf->set_paper('a4', 'landscape');

		return $pdf;
	}
}
