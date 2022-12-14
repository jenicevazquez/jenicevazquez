/****** Object:  Table [dbo].[contribuyentes]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[contribuyentes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [varchar](13) NULL,
	[razonsocial] [varchar](120) NULL,
	[licencia] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[autoenviar] [int] NULL CONSTRAINT [DF__contribuy__autoe__03BB8E22]  DEFAULT ((0)),
	[periodo] [int] NULL CONSTRAINT [DF__contribuy__perio__05A3D694]  DEFAULT ((2)),
	[validado] [int] NULL CONSTRAINT [DF_contribuyentes_validado]  DEFAULT ((0))
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
