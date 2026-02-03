<?php

namespace Eshop\Model;

use Eshop\Enums\OrderStatus;
use DateTime;

class Order
{
	public readonly int $id;
	public readonly int $productId;
	public readonly string $totalPrice;
	public readonly string $clientName;
	public readonly string $clientEmail;
	public readonly string $clientPhone;
	public readonly string $clientAddress;
	public readonly OrderStatus $status;
	public readonly DateTime $dateCreated;
	public readonly ?DateTime $dateModified;

	private function __construct(
		int $id,
		int $productId,
		string $totalPrice,
		string $clientName,
		string $clientEmail,
		string $clientPhone,
		string $clientAddress,
		OrderStatus $status,
		DateTime $dateCreated,
		?DateTime $dateModified,
	) {
		$this->id = $id;
		$this->productId = $productId;
		$this->totalPrice = $totalPrice;
		$this->clientName = $clientName;
		$this->clientEmail = $clientEmail;
		$this->clientPhone = $clientPhone;
		$this->clientAddress = $clientAddress;
		$this->status = $status;
		$this->dateCreated = $dateCreated;
		$this->dateModified = $dateModified;
	}

	public static function createNew(
		int $productId,
		string $totalPrice,
		string $clientName,
		string $clientEmail,
		string $clientPhone,
		string $clientAddress,
	): self {
		return new self(
			0,
			$productId,
			$totalPrice,
			$clientName,
			$clientEmail,
			$clientPhone,
			$clientAddress,
			OrderStatus::PENDING,
			new DateTime(),
			null,
		);
	}

	public static function fromDatabase(
		int $id,
		int $productId,
		string $totalPrice,
		string $clientName,
		string $clientEmail,
		string $clientPhone,
		string $clientAddress,
		OrderStatus $status,
		DateTime $dateCreated,
		?DateTime $dateModified,
	): self {
		return new self(
			$id,
			$productId,
			$totalPrice,
			$clientName,
			$clientEmail,
			$clientPhone,
			$clientAddress,
			$status,
			$dateCreated,
			$dateModified,
		);
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'product_id' => $this->productId,
			'total_price' => $this->totalPrice,
			'client_name' => $this->clientName,
			'client_email' => $this->clientEmail,
			'client_phone' => $this->clientPhone,
			'client_address' => $this->clientAddress,
			'status' => $this->status,
			'date_created' => $this->dateCreated,
			'date_modified' => $this->dateModified,
		];
	}
}