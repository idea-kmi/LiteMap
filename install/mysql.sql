
SET FOREIGN_KEY_CHECKS=0;

/*
Table structure for AuditDashboardView
*/

CREATE TABLE `AuditDashboardView` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ItemID` varchar(50) NOT NULL,
  `SessionID` varchar(50) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `Agent` varchar(255) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `Page` varchar(50) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for AuditGroupView
*/

CREATE TABLE `AuditGroupView` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `GroupID` varchar(50) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ViewType` varchar(255) DEFAULT NULL,
  `SessionID` varchar(50) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `Agent` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
Table structure for AuditHomepageView
*/

CREATE TABLE `AuditHomepageView` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `SessionID` varchar(50) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `Agent` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
Table structure for AuditNode
*/

CREATE TABLE `AuditNode` (
  `NodeID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Name` text,
  `Description` text,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) NOT NULL DEFAULT '',
  `NodeXML` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 246784 kB';

/*
Table structure for AuditNodeView
*/

CREATE TABLE `AuditNodeView` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `NodeID` varchar(50) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ViewType` varchar(255) DEFAULT NULL,
  `SessionID` varchar(50) NOT NULL DEFAULT '',
  `IPAddress` varchar(50) NOT NULL DEFAULT '',
  `Agent` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for AuditSearch
*/

CREATE TABLE `AuditSearch` (
  `SearchID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `SearchText` mediumtext,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `TagsOnly` enum('Y','N') NOT NULL DEFAULT 'N',
  `Type` varchar(255) DEFAULT 'main',
  `TypeItemID` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 246784 kB';

/*
Table structure for AuditSearchResult
*/

CREATE TABLE `AuditSearchResult` (
  `SearchID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `ItemID` varchar(50) NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `IsUser` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 246784 kB';

/*
Table structure for AuditSpamReports
*/

CREATE TABLE `AuditSpamReports` (
  `ReporterID` varchar(50) NOT NULL,
  `ItemID` varchar(50) NOT NULL DEFAULT '0',
  `Type` varchar(10) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
Table structure for AuditTesting
*/

CREATE TABLE `AuditTesting` (
  `TrialName` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ItemID` varchar(50) NOT NULL,
  `SessionID` varchar(50) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `Agent` varchar(255) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `TestElementID` varchar(50) DEFAULT NULL,
  `Event` text,
  `State` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for AuditTriple
*/

CREATE TABLE `AuditTriple` (
  `TripleID` varchar(50) NOT NULL DEFAULT '',
  `LinkTypeID` varchar(50) DEFAULT NULL,
  `FromID` varchar(50) DEFAULT NULL,
  `ToID` varchar(50) DEFAULT NULL,
  `Label` text,
  `FromContextTypeID` varchar(50) DEFAULT NULL,
  `ToContextTypeID` varchar(50) DEFAULT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) NOT NULL DEFAULT '',
  `TripleXML` mediumtext DEFAULT NULL 
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 246784 kB';

/*
Table structure for AuditURL
*/

CREATE TABLE `AuditURL` (
  `URLID` varchar(50) NOT NULL DEFAULT '',
  `TagID` varchar(50) DEFAULT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `URL` text,
  `Title` text,
  `Description` text,
  `Comments` text,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) NOT NULL DEFAULT '',
  `URLXML` text,
  `Clip` text,
  `ClipPath` text,
  `ClipHTML` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 484352 kB';

/*
Table structure for AuditViewNode
*/

CREATE TABLE `AuditViewNode` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ViewID` varchar(50) NOT NULL,
  `NodeID` varchar(50) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `XPos` float NOT NULL DEFAULT '0',
  `YPos` float NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for AuditViewTriple
*/

CREATE TABLE `AuditViewTriple` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ViewID` varchar(50) NOT NULL,
  `TripleID` varchar(50) NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for AuditVoting
*/

CREATE TABLE `AuditVoting` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ItemID` varchar(50) NOT NULL,
  `VoteType` enum('N','Y') NOT NULL DEFAULT 'Y',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `ChangeType` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 484352 kB';

/*
Table structure for Following
*/

CREATE TABLE `Following` (
  `UserID` varchar(50) NOT NULL,
  `ItemID` varchar(50) NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`ItemID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `Following_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for LinkType
*/

CREATE TABLE `LinkType` (
  `LinkTypeID` varchar(60) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Color` varchar(255) DEFAULT '#000000',
  `ToContextTypeID` varchar(50) DEFAULT NULL,
  `FromContextTypeID` varchar(50) DEFAULT NULL,
  `Label` text NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkTypeID`),
  KEY `UserID` (`UserID`),
  KEY `FromContextTypeID` (`FromContextTypeID`),
  KEY `ToContextTypeID` (`ToContextTypeID`),
  CONSTRAINT `LinkType_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `LinkType_ibfk_3` FOREIGN KEY (`ToContextTypeID`) REFERENCES `NodeType` (`NodeTypeID`) ON DELETE SET NULL,
  CONSTRAINT `LinkType_ibfk_4` FOREIGN KEY (`FromContextTypeID`) REFERENCES `NodeType` (`NodeTypeID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for LinkTypeGroup
*/

CREATE TABLE `LinkTypeGroup` (
  `LinkTypeGroupID` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Label` text NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkTypeGroupID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `LinkTypeGroup_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for LinkTypeGrouping
*/

CREATE TABLE `LinkTypeGrouping` (
  `LinkTypeGroupID` varchar(50) NOT NULL DEFAULT '0',
  `LinkTypeID` varchar(60) NOT NULL DEFAULT '0',
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkTypeGroupID`,`LinkTypeID`,`UserID`),
  KEY `UserID` (`UserID`),
  KEY `LinkTypeID` (`LinkTypeID`),
  CONSTRAINT `LinkTypeGrouping_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `LinkTypeGrouping_ibfk_2` FOREIGN KEY (`LinkTypeID`) REFERENCES `LinkType` (`LinkTypeID`) ON DELETE CASCADE,
  CONSTRAINT `LinkTypeGrouping_ibfk_3` FOREIGN KEY (`LinkTypeGroupID`) REFERENCES `LinkTypeGroup` (`LinkTypeGroupID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for Node
*/

CREATE TABLE `Node` (
  `NodeID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Name` text NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  `Description` text,
  `CurrentStatus` int(11) NOT NULL DEFAULT '0',
  `Image` varchar(255) DEFAULT NULL,
  `ImageThumbnail` varchar(255) DEFAULT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `CreatedFrom` varchar(50) NOT NULL DEFAULT 'cohere',
  `Private` enum('N','Y') DEFAULT 'Y',
  `StartDate` double DEFAULT NULL,
  `EndDate` double DEFAULT NULL,
  `LocationText` varchar(255) DEFAULT NULL,
  `LocationCountry` char(2) DEFAULT NULL,
  `LocationLat` decimal(18,15) DEFAULT NULL,
  `LocationLng` decimal(18,15) DEFAULT NULL,
  `NodeTypeID` varchar(50) DEFAULT NULL,
  `AdditionalIdentifier` varchar(255) DEFAULT NULL,
  `LocationAddress1` varchar(255) DEFAULT NULL,
  `LocationAddress2` varchar(255) DEFAULT NULL,
  `LocationPostCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`NodeID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `Node_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for NodeGroup
*/

CREATE TABLE `NodeGroup` (
  `NodeID` varchar(50) NOT NULL,
  `GroupID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`NodeID`,`GroupID`),
  KEY `GroupID` (`GroupID`),
  CONSTRAINT `NodeGroup_ibfk_1` FOREIGN KEY (`NodeID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE,
  CONSTRAINT `NodeGroup_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for NodeProperties
*/

CREATE TABLE `NodeProperties` (
  `NodeID` varchar(50) NOT NULL,
  `Property` varchar(50) NOT NULL,
  `Value` text,
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`NodeID`,`Property`),
  KEY `NodeID` (`NodeID`),
  CONSTRAINT `NodeProperty_ibfk_1` FOREIGN KEY (`NodeID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for NodeType
*/

CREATE TABLE `NodeType` (
  `NodeTypeID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  `Image` text,
  PRIMARY KEY (`NodeTypeID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `NodeType_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for NodeTypeGroup
*/

CREATE TABLE `NodeTypeGroup` (
  `NodeTypeGroupID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`NodeTypeGroupID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `NodeTypeGroup_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for NodeTypeGrouping
*/

CREATE TABLE `NodeTypeGrouping` (
  `NodeTypeGroupID` varchar(50) NOT NULL DEFAULT '0',
  `NodeTypeID` varchar(50) NOT NULL DEFAULT '0',
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`NodeTypeGroupID`,`NodeTypeID`,`UserID`),
  KEY `UserID` (`UserID`),
  KEY `ContextualNodeTypeID` (`NodeTypeID`),
  CONSTRAINT `NodeTypeGrouping_ibfk_1` FOREIGN KEY (`NodeTypeGroupID`) REFERENCES `NodeTypeGroup` (`NodeTypeGroupID`) ON DELETE CASCADE,
  CONSTRAINT `NodeTypeGrouping_ibfk_2` FOREIGN KEY (`NodeTypeID`) REFERENCES `NodeType` (`NodeTypeID`) ON DELETE CASCADE,
  CONSTRAINT `NodeTypeGrouping_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for Tag
*/

CREATE TABLE `Tag` (
  `TagID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `CreationDate` double NOT NULL,
  `ModificationDate` double NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`TagID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `Tag_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for TagNode
*/

CREATE TABLE `TagNode` (
  `NodeID` varchar(50) NOT NULL,
  `TagID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  PRIMARY KEY (`NodeID`,`TagID`,`UserID`),
  KEY `TagNode_TagID_Ind` (`TagID`),
  CONSTRAINT `FK_TagNode_1` FOREIGN KEY (`NodeID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE,
  CONSTRAINT `FK_TagNode_2` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`TagID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for TagTriple
*/

CREATE TABLE `TagTriple` (
  `TripleID` varchar(50) NOT NULL,
  `TagID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  PRIMARY KEY (`TripleID`,`TagID`,`UserID`),
  KEY `TagTriple_TagID_Ind` (`TagID`),
  CONSTRAINT `FK_TagTriple_1` FOREIGN KEY (`TripleID`) REFERENCES `Triple` (`TripleID`) ON DELETE CASCADE,
  CONSTRAINT `FK_TagTriple_2` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`TagID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for TagURL
*/

CREATE TABLE `TagURL` (
  `URLID` varchar(50) NOT NULL,
  `TagID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  PRIMARY KEY (`URLID`,`TagID`,`UserID`),
  KEY `TagURL_TagID_Ind` (`TagID`),
  CONSTRAINT `FK_TagURL_1` FOREIGN KEY (`URLID`) REFERENCES `URL` (`URLID`) ON DELETE CASCADE,
  CONSTRAINT `FK_TagURL_2` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`TagID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for TagUsers
*/

CREATE TABLE `TagUsers` (
  `UserID` varchar(50) NOT NULL,
  `TagID` varchar(50) NOT NULL,
  PRIMARY KEY (`TagID`,`UserID`),
  KEY `TagUsers_TagID_Ind` (`TagID`),
  KEY `FK_TagUsers_1` (`UserID`),
  CONSTRAINT `FK_TagUsers_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `FK_TagUsers_2` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`TagID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for Triple
*/

CREATE TABLE `Triple` (
  `TripleID` varchar(50) NOT NULL DEFAULT '',
  `LinkTypeID` varchar(60) NOT NULL DEFAULT '',
  `FromID` varchar(50) NOT NULL DEFAULT '',
  `ToID` varchar(50) NOT NULL DEFAULT '',
  `Label` text,
  `FromContextTypeID` varchar(50) DEFAULT NULL,
  `ToContextTypeID` varchar(50) DEFAULT NULL,
  `CurrentStatus` int(11) NOT NULL DEFAULT '0',
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  `FromLabel` text NOT NULL,
  `ToLabel` text NOT NULL,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `CreatedFrom` varchar(50) NOT NULL DEFAULT 'cohere',
  `Private` enum('Y','N') DEFAULT 'Y',
  `Description` text,
  PRIMARY KEY (`TripleID`),
  KEY `UserID` (`UserID`),
  KEY `FromContextTypeID` (`FromContextTypeID`),
  KEY `ToContextTypeID` (`ToContextTypeID`),
  KEY `FromID` (`FromID`),
  KEY `ToID` (`ToID`),
  CONSTRAINT `Triple_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for TripleGroup
*/

CREATE TABLE `TripleGroup` (
  `TripleID` varchar(50) NOT NULL DEFAULT '',
  `GroupID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`TripleID`,`GroupID`),
  KEY `GroupID` (`GroupID`),
  CONSTRAINT `TripleGroup_ibfk_1` FOREIGN KEY (`TripleID`) REFERENCES `Triple` (`TripleID`) ON DELETE CASCADE,
  CONSTRAINT `TripleGroup_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for URL
*/

CREATE TABLE `URL` (
  `URLID` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `CreationDate` double NOT NULL DEFAULT '0',
  `URL` text NOT NULL,
  `Title` text,
  `Private` enum('Y','N') NOT NULL DEFAULT 'Y',
  `CurrentStatus` int(11) NOT NULL DEFAULT '0',
  `Description` text,
  `ModificationDate` double NOT NULL DEFAULT '0',
  `CreatedFrom` varchar(50) NOT NULL DEFAULT '',
  `Clip` text,
  `ClipPath` text,
  `ClipHTML` text,
  `AdditionalIdentifier` text,
  PRIMARY KEY (`URLID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `URL_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for URLGroup
*/

CREATE TABLE `URLGroup` (
  `URLID` varchar(50) NOT NULL DEFAULT '',
  `GroupID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`URLID`,`GroupID`),
  KEY `GroupID` (`GroupID`),
  CONSTRAINT `urlgroup_ibfk_1` FOREIGN KEY (`URLID`) REFERENCES `URL` (`URLID`) ON DELETE CASCADE,
  CONSTRAINT `urlgroup_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for URLNode
*/

CREATE TABLE `URLNode` (
  `UserID` varchar(50) NOT NULL DEFAULT '0',
  `URLID` varchar(50) NOT NULL DEFAULT '0',
  `NodeID` varchar(50) NOT NULL DEFAULT '0',
  `CreationDate` double NOT NULL DEFAULT '0',
  `Comments` text,
  `CurrentStatus` int(11) DEFAULT '0',
  `ModificationDate` double DEFAULT NULL,
  PRIMARY KEY (`UserID`,`URLID`,`NodeID`),
  KEY `URLID` (`URLID`),
  KEY `TagID` (`NodeID`),
  CONSTRAINT `URLNode_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `URLNode_ibfk_2` FOREIGN KEY (`NodeID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE,
  CONSTRAINT `URLNode_ibfk_3` FOREIGN KEY (`URLID`) REFERENCES `URL` (`URLID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

/*
Table structure for UserGroup
*/

CREATE TABLE `UserGroup` (
  `GroupID` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  `IsAdmin` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`GroupID`,`UserID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `UserGroup_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `UserGroup_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for UserGroupJoin
*/

CREATE TABLE `UserGroupJoin` (
  `GroupID` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `AdminID` varchar(50) DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `CurrentStatus` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`GroupID`,`UserID`),
  KEY `UserID` (`UserID`),
  KEY `UserGroupJoin_ibfk_2` (`AdminID`),
  CONSTRAINT `UserGroupJoin_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `UserGroupJoin_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `UserGroupJoin_ibfk_3` FOREIGN KEY (`GroupID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for Users
*/

CREATE TABLE `Users` (
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Description` text,
  `Password` varchar(255) DEFAULT NULL,
  `LastLogin` double NOT NULL DEFAULT '0',
  `LastActive` double NOT NULL DEFAULT '0',
  `IsAdministrator` enum('N','Y') NOT NULL DEFAULT 'N',
  `IsGroup` enum('N','Y') NOT NULL DEFAULT 'N',
  `CurrentStatus` int(11) NOT NULL DEFAULT '0',
  `Website` varchar(255) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Private` enum('N','Y') NOT NULL DEFAULT 'N',
  `AuthType` varchar(10) NOT NULL DEFAULT 'litemap',
  `InvitationCode` varchar(50) DEFAULT NULL,
  `LocationText` varchar(255) DEFAULT NULL,
  `LocationCountry` char(2) DEFAULT NULL,
  `LocationLat` decimal(18,15) DEFAULT NULL,
  `LocationLng` decimal(18,15) DEFAULT NULL,
  `FollowSendEmail` enum('Y','N') NOT NULL DEFAULT 'N',
  `FollowRunInterval` varchar(50) NOT NULL DEFAULT 'monthly',
  `FollowLastRun` double NOT NULL DEFAULT '0',
  `Newsletter` enum('Y','N') NOT NULL DEFAULT 'N',
  `RegistrationKey` varchar(20) NOT NULL DEFAULT '0',
  `ValidationKey` varchar(20) DEFAULT NULL,
  `Interest` text,
  `RecentActivitiesEmail` enum('Y','N') NOT NULL DEFAULT 'N',
  `TestGroup` int(2) DEFAULT NULL,
  `IsOpenJoining` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for UsersAuthentication
*/

CREATE TABLE `UsersAuthentication` (
  `AuthID` varchar(50) NOT NULL DEFAULT '',
  `UserID` varchar(50) NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  `Provider` varchar(100) NOT NULL,
  `ProviderUID` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL DEFAULT '',
  `RegistrationKey` varchar(20) NOT NULL DEFAULT '0',
  `ValidationKey` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`AuthID`),
  UNIQUE KEY `ProviderIUD` (`ProviderUID`),
  KEY `UsersAuthentication_ibfk_1` (`UserID`),
  CONSTRAINT `UsersAuthentication_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for UsersObfuscation
*/

CREATE TABLE `UsersObfuscation` (
  `ObfuscationID` varchar(50) NOT NULL DEFAULT '',
  `ObfuscationKey` varchar(255) NOT NULL,
  `ObfuscationIV` varchar(255) NOT NULL,
  `DataID` varchar(50) NOT NULL,
  `DataURL` text NOT NULL,
  `Users` text NOT NULL,
  `SessionID` varchar(50) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `Agent` varchar(255) NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `CurrentStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ObfuscationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
Table structure for ViewNode
*/

CREATE TABLE `ViewNode` (
  `ViewID` varchar(50) NOT NULL,
  `NodeID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  `XPos` float NOT NULL DEFAULT '0',
  `YPos` float NOT NULL DEFAULT '0',
  `MediaIndex` double NOT NULL DEFAULT '-1',
  PRIMARY KEY (`ViewID`,`NodeID`,`UserID`),
  KEY `UserID` (`UserID`),
  KEY `ViewNode_ibfk_3` (`NodeID`),
  CONSTRAINT `ViewNode_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `ViewNode_ibfk_2` FOREIGN KEY (`ViewID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE,
  CONSTRAINT `ViewNode_ibfk_3` FOREIGN KEY (`NodeID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for ViewTriple
*/

CREATE TABLE `ViewTriple` (
  `ViewID` varchar(50) NOT NULL,
  `TripleID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`ViewID`,`TripleID`,`UserID`),
  KEY `UserID` (`UserID`),
  KEY `ViewTriple_ibfk_3` (`TripleID`),
  CONSTRAINT `ViewTriple_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `ViewTriple_ibfk_2` FOREIGN KEY (`ViewID`) REFERENCES `Node` (`NodeID`) ON DELETE CASCADE,
  CONSTRAINT `ViewTriple_ibfk_3` FOREIGN KEY (`TripleID`) REFERENCES `Triple` (`TripleID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*
Table structure for Voting
*/
CREATE TABLE `Voting` (
  `VoteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` varchar(50) NOT NULL DEFAULT '',
  `ItemID` varchar(50) NOT NULL,
  `VoteType` enum('N','Y') NOT NULL DEFAULT 'Y',
  `CreationDate` double NOT NULL DEFAULT '0',
  `ModificationDate` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`VoteID`),
  KEY `UserID` (`UserID`),
  KEY `ItemID` (`ItemID`),
  CONSTRAINT `Voting_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

SET FOREIGN_KEY_CHECKS=1;
