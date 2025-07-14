<?php

use MediaWiki\Hook\SidebarBeforeOutputHook;
use MediaWiki\Title\Title;
use MediaWiki\User\UserGroupManager;

class GroupsSidebar implements SidebarBeforeOutputHook {

	private UserGroupManager $userGroupManager;

	public function __construct( UserGroupManager $userGroupManager ) {
		$this->userGroupManager = $userGroupManager;
	}

	/**
	 * @param Skin $skin
	 * @param array &$sidebar
	 */
	public function onSidebarBeforeOutput( $skin, &$sidebar ): void {
		$groups = $this->userGroupManager->getUserEffectiveGroups( $skin->getUser() );
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
