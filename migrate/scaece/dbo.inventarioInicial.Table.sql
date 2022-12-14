/****** Object:  Table [dbo].[inventarioInicial]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[inventarioInicial](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fechacertificacion] [date] NULL,
	[rubro] [varchar](50) NULL,
	[tipo] [varchar](50) NULL,
	[archivo] [varchar](50) NULL,
	[licencia] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[created_by] [int] NULL,
	[updated_by] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
