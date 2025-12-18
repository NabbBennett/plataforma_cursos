<style>
	#imageModal {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, 0.8);
		backdrop-filter: blur(4px);
		z-index: 9999;
		align-items: center;
		justify-content: center;
		padding: 1.5rem;
	}

	#imageModalInner {
		position: relative;
		max-width: 90vw;
		max-height: 90vh;
		display: flex;
		flex-direction: column;
		gap: 0.75rem;
		align-items: center;
	}

	#imageModalContent {
		max-width: 90vw;
		max-height: 80vh;
		object-fit: contain;
		border-radius: 12px;
		box-shadow: 0 15px 40px rgba(0,0,0,0.45);
		background: #111;
	}

	#imageModalCaption {
		color: #f5f5f5;
		text-align: center;
		font-size: 1rem;
		line-height: 1.4;
		max-width: 80vw;
	}

	#imageModalClose {
		position: absolute;
		top: -12px;
		right: -12px;
		background: rgba(0,0,0,0.75);
		color: #fff;
		border: none;
		width: 36px;
		height: 36px;
		border-radius: 50%;
		font-size: 1.2rem;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		transition: background 0.2s ease, transform 0.2s ease;
	}

	#imageModalClose:hover {
		background: rgba(255,255,255,0.25);
		transform: scale(1.05);
	}

	@media (max-width: 576px) {
		#imageModalContent {
			max-width: 95vw;
			max-height: 70vh;
		}

		#imageModalCaption {
			font-size: 0.95rem;
		}
	}
</style>

<div id="imageModal" role="dialog" aria-modal="true">
	<div id="imageModalInner">
		<button id="imageModalClose" aria-label="Cerrar imagen" onclick="window.closeImageModal && window.closeImageModal()">×</button>
		<img id="imageModalContent" alt="">
		<div id="imageModalCaption"></div>
	</div>
</div>
