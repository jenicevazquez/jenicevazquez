/****** Object:  Table [dbo].[rectificaciones]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rectificaciones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[aduana] [varchar](5) NULL,
	[despacho] [varchar](5) NULL,
	[clave] [varchar](5) NULL,
	[fechapago] [date] NULL,
	[pedimento] [varchar](10) NULL,
	[patente] [varchar](5) NULL,
	[fechaOriginal] [date] NULL,
	[pedimento_id] [int] NULL,
	[pedimentoO_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_rectificaciones] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
