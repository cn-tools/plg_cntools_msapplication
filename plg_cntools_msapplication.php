<?php
/**
 * @Copyright
 * @package     MSApplication
 * @author      Clemens Neubauer {@link cn-tools@gmx.at#}
 * @version     0-0-1
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
	function plgSystemPlg_CNTools_MSApplication(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRender()
    {

		$app = JFactory::getApplication();
		$script = '';
		if ($this->params->get('caption') != ''){
			$script .= '<meta name="application-name" content="'.$this->params->get('caption').'" /> ';
		} elseif ($app->getCfg('sitename') != ''){
			$script .= '<meta name="application-name" content="'.$app->getCfg('sitename').'" /> ';
		}
		if ($this->params->get('tooltip') != ''){
			$script .= '<meta name="msapplication-tooltip" content="'.$this->params->get('tooltip').'" /> ';
		} elseif ($app->getCfg('MetaDesc') != ''){
			$script .= '<meta name="msapplication-tooltip" content="'.$app->getCfg('MetaDesc').'" /> ';
		}
		if (($script != '') AND ($this->params->get('color') != '')){
			$script .= '<meta name="msapplication-TileColor" content="'.$this->params->get('color').'" /> ';
		}
		if ($this->params->get('image70x70') != ''){
			$script .= '<meta name="msapplication-square70x70logo" content="'.JURI::base().htmlspecialchars($this->params->get('image70x70')).'" /> ';
		}
		if ($this->params->get('image150x150') != ''){
			$script .= '<meta name="msapplication-square150x150logo" content="'.JURI::base().htmlspecialchars($this->params->get('image150x150')).'" /> ';
		}
		if ($this->params->get('image310x150') != ''){
			$script .= '<meta name="msapplication-wide310x150logo" content="'.JURI::base().htmlspecialchars($this->params->get('image310x150')).'" /> ';
		}
		if ($this->params->get('image310x310') != ''){
			$script .= '<meta name="msapplication-square310x310logo" content="'.JURI::base().htmlspecialchars($this->params->get('image310x310')).'" /> ';
		}

		$lRssURL = trim($this->params->get('rss_url', ''));
		$lIntVal = (int)$this->params->get('rss_frequency');
		if (($lIntVal >> 0) and ($lRssURL != '')){
			//JURI::base().'index.php?option=com_content&view=category&layout=blog'
			//JURI::base().'index.php?option=com_content&view=category'
			//JURI::base().'index.php?format=feed&type=rss'
			//JURI::base().'index.php?option=com_content&view=category&layout=blog&id='
			$script .= '<meta name="msapplication-notification" content="frequency='.$lIntVal.';polling-uri='.JURI::base().'index.php?option=com_content&view=category&layout=blog&id='.$lRssURL.'&format=feed&type='.$this->params->get('rss_type', '').'" /> ';
		}

		if ($script != ''){
			$buffer = JResponse::getBody();
			$pos = strrpos($buffer, "</head>");
			if($pos > 0)
			{
				$buffer = substr($buffer, 0, $pos).$script.substr($buffer, $pos);
			}		

			JResponse::setBody($buffer);
		}

		return true;
	}
}
?>