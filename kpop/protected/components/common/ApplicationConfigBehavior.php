<?php
class ApplicationConfigBehavior extends CBehavior
{
	/**
	 * Declares events and the event handler methods
	 * See yii documentation on behavior
	 */
	public function events()
	{
		$this->onModuleCreate = array($this, 'changeModulePaths');
		$this->onModuleCreate(new CEvent($this->owner));
		$this->owner->run(); // Run application.
	}

	/**
	 * Load configuration that cannot be put in config/main
	 */
	public function onModuleCreate($event)
	{
		$this->raiseEvent('onModuleCreate', $event);
	}

	// onModuleCreate event handler.
	// A sender must have controllerPath and viewPath properties.
	protected function changeModulePaths($event)
	{
		$server = parse_url(Yii::app()->request->hostInfo);
		$domainInfo = explode(".", $server["host"]);
		if((int) $domainInfo[0] != 0){
			$event->sender->defaultController = "song";
		}
	}
}