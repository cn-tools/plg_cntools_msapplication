<?php
/**
 * @Copyright
 * @package     MSApplication
 * @author      Clemens Neubauer {@link cn-tools@gmx.at}
 * @version     0-0-2
 * @date        Created on 03-Aug-2014
 * @link        Project Site {@link https://github.com/cn-tools/plg_cntools_msapplication}
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class plgSystemPlg_CNTools_MSApplication extends JPlugin
{

	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRender ()
	{
		$app = JFactory::getApplication();
		
		$lCaption = trim($this->params->get('caption'));
		if ($lCaption == '')
		{
			$lCaption = trim($app->getCfg('sitename'));
		}
		
		$lToolTip = trim($this->params->get('tooltip'));
		if ($lToolTip == '')
		{
			$lToolTip = trim($app->getCfg('MetaDesc'));
		}
		
		$lImage70x70 = $this->params->get('image70x70');
		$lImage150x150 = $this->params->get('image150x150');
		$lImage310x150 = $this->params->get('image310x150');
		$lImage310x310 = $this->params->get('image310x310');
		$lRssURL = trim($this->params->get('rss_url', ''));
		$lRssFreq = (int) $this->params->get('rss_frequency');
		
		$script = '';
		if ($this->params->get('usebaseurl'))
		{
			$script .= '<meta name="msapplication-starturl" content="' . JURI::base() . '" /> ';
		}
		if ($lCaption != '')
		{
			$script .= '<meta name="application-name" content="' . $lCaption . '" /> ';
		}
		if ($lToolTip != '')
		{
			$script .= '<meta name="msapplication-tooltip" content="' . $lToolTip . '" /> ';
		}
		if ($this->params->get('xmlfile'))
		{
			// todo: add code to get the right xml file
		}
		else
		{
			$script .= '<meta name="msapplication-config" content="none" /> ';
		}
		
		$lColor = trim($this->params->get('color'));
		if (($lColor != '') and (($lCaption != '') or ($lCaption != '')))
		{
			$script .= '<meta name="msapplication-TileColor" content="' . $lColor . '" /> ';
		}
		
		$lColor = trim($this->params->get('navbtncolor'));
		if (($lColor != '') and (($lCaption != '') or ($lCaption != '')))
		{
			$script .= '<meta name="msapplication-navbutton-color" content="' . $lColor . '" /> ';
		}
		
		if ($lImage70x70 != '')
		{
			$script .= '<meta name="msapplication-square70x70logo" content="' . JURI::base() . htmlspecialchars($lImage70x70) . '" /> ';
		}
		if ($lImage150x150 != '')
		{
			$script .= '<meta name="msapplication-square150x150logo" content="' . JURI::base() . htmlspecialchars($lImage150x150) . '" /> ';
		}
		if ($lImage310x150 != '')
		{
			$script .= '<meta name="msapplication-wide310x150logo" content="' . JURI::base() . htmlspecialchars($lImage310x150) . '" /> ';
		}
		if ($lImage310x310 != '')
		{
			$script .= '<meta name="msapplication-square310x310logo" content="' . JURI::base() . htmlspecialchars($lImage310x310) . '" /> ';
		}
		
		$lRssURL = trim($this->params->get('rss_url', ''));
		$lRssFreq = (int) $this->params->get('rss_frequency');
		if ($lRssFreq >> 0)
		{
			$script .= '<meta name="msapplication-notification" content="frequency=' . $lRssFreq . ';polling-uri=' . JURI::base() . 'index.php?option=com_content&view=category&layout=blog&format=feed&type=' . $this->params->get('rss_type', '');
			
			if ($lRssURL != '')
			{
				$script .= '&id=' . $lRssURL;
			}
			$script .= '" /> ';
		}
		
		if ($script != '')
		{
			$buffer = JResponse::getBody();
			$pos = strrpos($buffer, "</head>");
			if ($pos > 0)
			{
				$buffer = substr($buffer, 0, $pos) . $script . substr($buffer, $pos);
			}
			
			JResponse::setBody($buffer);
		}
		
		return true;
	}
}
?>