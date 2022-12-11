/****** Object:  Table [dbo].[vucem]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[vucem](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[rfc] [varchar](20) NULL,
	[pass] [varchar](500) NULL,
	[cerfile] [varchar](500) NULL,
	[keyfile] [varchar](500) NULL,
	[passfile] [varchar](500) NULL,
	[estado] [int] NULL,
	[licencia] [int] NULL,
	[created_by] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[updated_by] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
