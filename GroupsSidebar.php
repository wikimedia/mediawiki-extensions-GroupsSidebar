<?php

use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;

class GroupsSidebar {
	/**
	 * Gets called by Hook SidebarBeforeOutput
	 *
	 * @param Skin $skin
	 * @param array &$sidebar
	 */
	public static function efHideSidebar( Skin $skin, &$sidebar ) {
		$groups = MediaWikiServices::getInstance()
			->getUserGroupManager()
			->getUserEffectiveGroups( $skin->getUser() );
		foreach ( $groups as $group ) {
			$message = 'sidebar-' . $group;
			# addToSidebar currently won't throw errors if we call it
			# with nonexisting pages, but better check and be sure
			if ( Title::newFromText( $message, NS_MEDIAWIKI )->exists() ) {
				$skin->addToSidebar( $sidebar, $message );
			}
		}
	}
}
