<?php
// phpcs:ignoreFile

defined( 'ABSPATH' ) || exit;

/**
 * The Template for displaying referral credits in the my account area.
 * This template can be overridden by copying it to yourtheme/automatewoo/referrals/account-tab.php.
 *
 * @see https://docs.woothemes.com/document/template-structure/
 *
 * @var AutomateWoo\Referrals\Advocate $advocate
 * @var int $available_store_credit
 * @var array $referrals
 * @var array $used_referrals
 * @var string $share_link
 */

?>

<h2 class="text-center">Current Referrals</h2>

<?php if ( $referrals || $used_referrals ) : ?>

	<?php if ( AW_Referrals()->is_using_store_credit() ) : ?>
		<p>
			<?php if ( $available_store_credit ) : ?>
				<?php printf( esc_html__( "You currently have %s store credit available.", 'automatewoo-referrals' ), '<strong>' . wc_price( $available_store_credit ) . '</strong>' ); ?>
			<?php else : ?>
				<?php esc_html_e( "You do not have any store credit available.", 'automatewoo-referrals' ); ?>
			<?php endif; ?>
			<?php echo '<a href="/my-account/refer-friend/" target="_blank">Refer a friend here.</a>'; ?>
		</p>
	<?php endif; ?>

	<?php
	AW_Referrals()->get_template(
		'account-tab-referral-tables.php',
		[
			'referrals'      => $referrals,
			'used_referrals' => $used_referrals
		]
	);
	?>

<?php else : ?>
	<p><?php esc_html_e( "You do not have any completed referrals yet.", 'automatewoo-referrals' ); ?> <?php echo '<a href="/my-account/refer-friend/">Refer a friend here.</a>'; ?></p>
<?php endif ?>