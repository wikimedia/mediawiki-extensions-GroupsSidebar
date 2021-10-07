<?php

use MediaWiki\MediaWikiServices;

class GroupsSidebar {
	/**
	 * Gets called by Hook SkinBuildSidebar
	 *
	 * @param Skin $skin
	 * @param Sidebar &$bar
	 * @return bool|array
	 */
	public static function efHideSidebar( $skin, &$bar ) {
		$groups = MediaWikiServices::getInstance()
			->getUserGroupManager()
			->getUserEffectiveGroups( $skin->getUser() );
		foreach ( $groups as $group ) {
			$message = 'sidebar-' . $group;
			# addToSidebar currently won't throw errors if we call it
			# with nonexisting pages, but better check and be sure
			if ( Title::newFromText( $message, NS_MEDIAWIKI )->exists() ) {
				$skin->addToSidebar( $bar, $message );
			}
		}
		return true;
	}
}
